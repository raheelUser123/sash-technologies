<?php
/**
 * Sash Technologies — Careers application handler
 *
 * Receives the 3-step job application form (with resume upload),
 * stores the resume, creates a ClickUp task, and sends an admin
 * email plus a customer confirmation email (PHPMailer).
 */

declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

function respond(bool $success, string $message, array $extra = []): void
{
    http_response_code($success ? 200 : 422);
    echo json_encode(
        array_merge(['success' => $success, 'message' => $message], $extra),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
    exit;
}

function clean_text($value, int $maxLength = 5000): string
{
    $value = is_string($value) ? trim($value) : '';
    $value = strip_tags($value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    return mb_substr($value, 0, $maxLength);
}

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    respond(false, 'Invalid request.');
}

/* Honeypot anti-spam */
if (trim((string) ($_POST['urd_company_fax'] ?? '')) !== '') {
    respond(true, 'Your application has been submitted successfully.');
}

/* Simple rate limiter */
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
if ($ip !== 'unknown') {
    $dir = sys_get_temp_dir() . '/urd-form-rate-limit';
    @mkdir($dir, 0700, true);
    $rf = $dir . '/' . hash('sha256', $ip) . '.txt';
    $last = is_file($rf) ? (int) file_get_contents($rf) : 0;
    if ($last > 0 && (time() - $last) < FORM_RATE_LIMIT_SECONDS) {
        respond(false, 'Please wait a few seconds before submitting another request.');
    }
    @file_put_contents($rf, (string) time(), LOCK_EX);
}

/* Collect + clean fields */
$first     = clean_text($_POST['first_name'] ?? '', 100);
$last      = clean_text($_POST['last_name'] ?? '', 100);
$name      = trim($first . ' ' . $last);
$email     = clean_text($_POST['email'] ?? '', 160);
$phone     = clean_text($_POST['phone'] ?? '', 180);
$position  = clean_text($_POST['position'] ?? '', 180);
$gender    = clean_text($_POST['gender'] ?? '', 40);
$dob       = clean_text($_POST['dob'] ?? '', 40);
$age       = clean_text($_POST['age'] ?? '', 10);
$location  = clean_text($_POST['location'] ?? '', 140);
$linkedin  = clean_text($_POST['linkedin'] ?? '', 300);
$portfolio = clean_text($_POST['portfolio'] ?? '', 400);
$cover     = clean_text($_POST['message'] ?? '', 4000);

if (
    $first === ''
    || $last === ''
    || $email === ''
    || !filter_var($email, FILTER_VALIDATE_EMAIL)
    || $phone === ''
    || $position === ''
) {
    respond(false, 'Please fill in your name, email, phone number, and the position.');
}

/* Handle resume upload */
$resumeName = '';
$resumeStored = '';
$fileError = $_FILES['resume']['error'] ?? UPLOAD_ERR_NO_FILE;

if (isset($_FILES['resume']) && $fileError === UPLOAD_ERR_OK) {
    $file = $_FILES['resume'];
    if ((int) $file['size'] > 5 * 1024 * 1024) {
        respond(false, 'Your resume must be under 5 MB.');
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx', 'txt', 'rtf'];
    if (!in_array($ext, $allowed, true)) {
        respond(false, 'Please upload a PDF, DOC, DOCX, RTF, or TXT resume.');
    }

    $uploadDir = __DIR__ . '/uploads/resumes';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0775, true);
    }

    $stored = 'applicant-' . date('Ymd_His') . '-' . bin2hex(random_bytes(4)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $stored)) {
        if (!@copy($file['tmp_name'], $uploadDir . '/' . $stored)) {
            respond(false, 'We could not save your resume. Please try again.');
        }
    }

    $resumeName = $file['name'];
    $resumeStored = $stored;
} else {
    if ($fileError === UPLOAD_ERR_NO_FILE) {
        respond(false, 'Please upload your resume (PDF, DOC, DOCX, RTF, or TXT).');
    }
    respond(false, 'There was a problem with your resume upload. Please try again.');
}

$resumeUrl = '';
if ($resumeStored !== '') {
    $base = '';
    $doc_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $site_root = rtrim(str_replace('\\', '/', dirname(__DIR__)), '/');
    if ($doc_root !== '' && strpos(strtolower($site_root), strtolower($doc_root)) === 0) {
        $base = substr($site_root, strlen($doc_root));
    }
    $base = '/' . ltrim($base, '/') . '/';
    $base = preg_replace('#/+#', '/', $base);
    $resumeUrl = $base . 'uploads/resumes/' . $resumeStored;
}

$application = [
    'first_name'  => $first,
    'last_name'   => $last,
    'name'        => $name,
    'email'       => $email,
    'phone'       => $phone,
    'position'    => $position,
    'gender'      => $gender,
    'dob'         => $dob,
    'age'         => $age,
    'location'    => $location,
    'linkedin'    => $linkedin,
    'portfolio'   => $portfolio,
    'cover'       => $cover,
    'resume_name' => $resumeName,
    'resume_url'  => $resumeUrl,
    'form_type'   => 'job_application',
    'submitted_at'=> date('Y-m-d H:i:s T'),
    'ip'          => $ip,
];

/**
 * Create a ClickUp task for the job application (best-effort).
 */
function create_clickup_task(array $app): array
{
    $configured = defined('CLICKUP_API_TOKEN')
        && CLICKUP_API_TOKEN !== ''
        && strpos(CLICKUP_API_TOKEN, 'REPLACE_') === false
        && defined('CLICKUP_LIST_ID')
        && CLICKUP_LIST_ID !== '';

    if (!$configured) {
        return ['success' => false, 'error' => 'ClickUp not configured'];
    }

    $rows = [
        'Name'      => $app['name'],
        'Email'     => $app['email'],
        'Phone'     => $app['phone'],
        'Location'  => $app['location'],
        'LinkedIn'  => $app['linkedin'],
        'Portfolio' => $app['portfolio'],
        'Cover'     => $app['cover'],
        'Resume'    => $app['resume_url'] !== '' ? SITE_URL . $app['resume_url'] : $app['resume_name'],
    ];
    $desc = 'Job Application — ' . $app['position'] . "\n\n";
    foreach ($rows as $k => $v) {
        $desc .= '**' . $k . ':** ' . ($v !== '' ? $v : '—') . "\n";
    }

    $data = [
        'name'               => '[Careers] ' . $app['position'] . ' — ' . $app['name'],
        'markdown_description' => $desc,
        'tags'               => ['careers'],
    ];

    $ch = curl_init('https://api.clickup.com/api/v2/list/' . CLICKUP_LIST_ID . '/task');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => ['Authorization: ' . CLICKUP_API_TOKEN, 'Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($data),
    ]);
    $resp = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code >= 200 && $code < 300) {
        $json = json_decode((string) $resp, true);
        return ['success' => true, 'url' => (string) ($json['url'] ?? '')];
    }

    return ['success' => false, 'error' => 'ClickUp HTTP ' . $code];
}

/**
 * Build a configured PHPMailer instance.
 */
function build_mailer(bool $isAdmin, array $app): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);

    if (SMTP_USERNAME !== '' && SMTP_PASSWORD !== '') {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = (int) SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
    }

    $from = MAIL_FROM_ADDRESS !== '' ? MAIL_FROM_ADDRESS : 'no-reply@' . (parse_url(SITE_URL, PHP_URL_HOST) ?: 'sashtechnologies.com');
    $fromName = MAIL_FROM_NAME !== '' ? MAIL_FROM_NAME : 'Sash Technologies';
    $mail->setFrom($from, $fromName);

    if ($isAdmin) {
        $to = MAIL_TO_ADDRESS !== '' ? MAIL_TO_ADDRESS : $from;
        $mail->addAddress($to, MAIL_TO_NAME !== '' ? MAIL_TO_NAME : 'Sash Technologies');
    } else {
        $mail->addAddress($app['email'], $app['name']);
        $mail->addReplyTo($from, 'Sash Technologies');
    }

    return $mail;
}

function detail_rows(array $rows): string
{
    $html = '';
    foreach ($rows as $label => $value) {
        $html .= '<tr>'
            . '<td style="padding:8px 12px;font-weight:700;color:#1f2b44;vertical-align:top;white-space:nowrap;">' . esc($label) . '</td>'
            . '<td style="padding:8px 12px;color:#4a5470;">' . $value . '</td>'
            . '</tr>';
    }
    return $html;
}

function send_career_emails(array $app, string $clickupUrl): array
{
    $rows = [
        'Position'            => $app['position'],
        'Full name'           => $app['name'],
        'Email'               => $app['email'],
        'Phone'               => $app['phone'],
        'Gender'              => $app['gender'] !== '' ? $app['gender'] : '—',
        'Date of birth'       => $app['dob'] !== '' ? $app['dob'] : '—',
        'Age'                 => $app['age'] !== '' ? $app['age'] : '—',
        'Location'            => $app['location'] !== '' ? $app['location'] : '—',
        'LinkedIn'            => $app['linkedin'] !== '' ? '<a href="' . esc($app['linkedin']) . '">' . esc($app['linkedin']) . '</a>' : '—',
        'Portfolio / Website' => $app['portfolio'] !== '' ? '<a href="' . esc($app['portfolio']) . '">' . esc($app['portfolio']) . '</a>' : '—',
        'Cover note'          => $app['cover'] !== '' ? nl2br(esc($app['cover'])) : '—',
        'Resume'              => $app['resume_url'] !== ''
            ? '<a href="' . esc(SITE_URL . $app['resume_url']) . '">' . esc($app['resume_name']) . '</a>'
            : esc($app['resume_name']),
    ];

    $clickLink = $clickupUrl !== '' ? '<p style="margin:20px 0 0;">📋 <a href="' . esc($clickupUrl) . '" style="color:#356be0;">View in ClickUp</a></p>' : '';

    $adminHtml = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:640px;margin:auto;border:1px solid #e3e8f2;border-radius:14px;overflow:hidden;">'
        . '<div style="background:linear-gradient(135deg,#0b1023,#1a2350);padding:22px 26px;"><h2 style="color:#fff;margin:0;font-size:20px;">New job application — ' . esc($app['position']) . '</h2></div>'
        . '<table style="width:100%;border-collapse:collapse;background:#fff;">' . detail_rows($rows) . '</table>'
        . '<div style="padding:14px 26px 26px;color:#8993a7;font-size:12px;">Submitted ' . esc($app['submitted_at']) . ' · IP ' . esc($app['ip']) . '</div>'
        . $clickLink
        . '</div>';

    $customerHtml = '<div style="font-family:Arial,Helvetica,sans-serif;max-width:640px;margin:auto;border:1px solid #e3e8f2;border-radius:14px;overflow:hidden;">'
        . '<div style="background:linear-gradient(135deg,#0b1023,#1a2350);padding:22px 26px;"><h2 style="color:#fff;margin:0;font-size:20px;">Application received</h2></div>'
        . '<div style="padding:26px;color:#3a4560;line-height:1.7;">'
        . '<p>Hi ' . esc($app['first_name']) . ',</p>'
        . '<p>Thanks for applying for the <strong>' . esc($app['position']) . '</strong> position. Your application and resume have been received safely.</p>'
        . '<p>We read every application and will be in touch if we would like to move forward.</p>'
        . '</div>'
        . '</div>';

    $adminSubject = 'New application: ' . $app['position'] . ' — ' . $app['name'];
    $customerSubject = 'Application received — ' . $app['position'] . ' | Sash Technologies';

    $adminSuccess = true;
    $adminError = '';
    try {
        $adminMail = build_mailer(true, $app);
        $adminMail->Subject = $adminSubject;
        $adminMail->Body = $adminHtml;
        $adminMail->send();
    } catch (\Throwable $e) {
        $adminSuccess = false;
        $adminError = $e->getMessage();
    }

    $customerSuccess = true;
    try {
        $customerMail = build_mailer(false, $app);
        $customerMail->Subject = $customerSubject;
        $customerMail->Body = $customerHtml;
        $customerMail->send();
    } catch (\Throwable $e) {
        $customerSuccess = false;
    }

    return [
        'success'   => $adminSuccess,
        'error'     => $adminError,
        'customer_email_success' => $customerSuccess,
    ];
}

$clickup = create_clickup_task($application);
$email   = send_career_emails($application, $clickup['url'] ?? '');

if (!$clickup['success']) {
    error_log('ClickUp careers task failed: ' . ($clickup['error'] ?? 'unknown'));
}
if (!$email['success']) {
    error_log('Careers admin email failed: ' . ($email['error'] ?? 'unknown'));
}

if ($email['success']) {
    respond(true, 'Your application has been submitted successfully.', [
        'email_success' => true,
        'customer_confirmation_sent' => $email['customer_email_success'] ?? false,
        'clickup_success' => $clickup['success'] ?? false,
        'clickup_task_url' => $clickup['url'] ?? '',
    ]);
}

respond(false, 'We could not send your application by email. Please try again, or email your resume to info@sashtechnologies.com.', [
    'email_success' => false,
    'clickup_success' => $clickup['success'] ?? false,
]);