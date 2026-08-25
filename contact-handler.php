<?php
/**
 * Sash Technologies
 * Complete website form handler
 *
 * Handles:
 * - General inquiry
 * - Strategy call
 * - Lead capture
 * - Proposal request
 *
 * Delivers:
 * - ClickUp lead task
 * - Admin branded HTML email
 * - Customer confirmation HTML email
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/email-template.php';

/**
 * Return JSON response and stop execution.
 */
function respond(
    bool $success,
    string $message,
    array $extra = []
): void {
    http_response_code($success ? 200 : 422);

    echo json_encode(
        array_merge(
            [
                'success' => $success,
                'message' => $message,
            ],
            $extra
        ),
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );

    exit;
}

/**
 * Clean text submitted from a form.
 */
function clean_text($value, int $maxLength = 5000): string
{
    $value = is_string($value) ? trim($value) : '';

    $value = strip_tags($value);

    $value = preg_replace(
        '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u',
        '',
        $value
    ) ?? '';

    return mb_substr($value, 0, $maxLength);
}

/**
 * Detect visitor IP address.
 */
function client_ip(): string
{
    $forwarded = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '';

    if ($forwarded !== '') {
        $candidate = trim(explode(',', $forwarded)[0]);

        if (filter_var($candidate, FILTER_VALIDATE_IP)) {
            return $candidate;
        }
    }

    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    return filter_var($remote, FILTER_VALIDATE_IP)
        ? $remote
        : 'unknown';
}

/**
 * Simple form rate limiter.
 */
function rate_limit(string $ip): void
{
    if ($ip === 'unknown') {
        return;
    }

    $directory = sys_get_temp_dir() . '/urd-form-rate-limit';

    if (!is_dir($directory)) {
        @mkdir($directory, 0700, true);
    }

    $file = $directory . '/' . hash('sha256', $ip) . '.txt';

    $lastSubmission = is_file($file)
        ? (int) file_get_contents($file)
        : 0;

    if (
        $lastSubmission > 0
        && (time() - $lastSubmission) < FORM_RATE_LIMIT_SECONDS
    ) {
        respond(
            false,
            'Please wait a few seconds before submitting another request.'
        );
    }

    @file_put_contents(
        $file,
        (string) time(),
        LOCK_EX
    );
}

/**
 * Check if ClickUp credentials are configured.
 */
function clickup_is_configured(): bool
{
    return defined('CLICKUP_API_TOKEN')
        && CLICKUP_API_TOKEN !== ''
        && strpos(CLICKUP_API_TOKEN, 'REPLACE_') === false
        && strpos(CLICKUP_API_TOKEN, 'PASTE_') === false
        && strpos(CLICKUP_API_TOKEN, '----------') === false
        && defined('CLICKUP_LIST_ID')
        && CLICKUP_LIST_ID !== '';
}

/**
 * Create ClickUp task inside the configured Leads list.
 */
function create_clickup_task(array $lead): array
{
    if (!clickup_is_configured()) {
        return [
            'success' => false,
            'error' => 'ClickUp credentials are not configured.',
        ];
    }

    if (!function_exists('curl_init')) {
        return [
            'success' => false,
            'error' => 'PHP cURL extension is not enabled.',
        ];
    }

    $typeLabels = [
        'strategy_call' => 'Strategy Call',
        'lead_capture' => 'Lead Capture',
        'proposal' => 'Proposal Request',
        'general_inquiry' => 'Website Inquiry',
    ];

    $formType = $lead['form_type'] ?? 'general_inquiry';

    $typeLabel = $typeLabels[$formType]
        ?? ucwords(str_replace('_', ' ', $formType));

    $servicePart = $lead['service'] !== ''
        ? ' - ' . $lead['service']
        : '';

    $taskName =
        $lead['name']
        . $servicePart
        . ' - '
        . $typeLabel;

    $description =
        "## New website lead\n\n"
        . "**Form:** {$typeLabel}\n"
        . "**Name:** {$lead['name']}\n"
        . "**Business:** "
        . ($lead['business'] ?: 'Not provided')
        . "\n"
        . "**Email:** {$lead['email']}\n"
        . "**Phone:** "
        . ($lead['phone'] ?: 'Not provided')
        . "\n"
        . "**Service:** "
        . ($lead['service'] ?: 'Not selected')
        . "\n"
        . "**Budget:** "
        . ($lead['budget'] ?: 'Not provided')
        . "\n"
        . "**Timeframe:** "
        . ($lead['timeframe'] ?: 'Not provided')
        . "\n"
        . "**Preferred date:** "
        . ($lead['preferred_date'] ?: 'Not provided')
        . "\n"
        . "**Preferred time:** "
        . ($lead['preferred_time'] ?: 'Not provided')
        . "\n"
        . "**Timezone:** "
        . ($lead['timezone'] ?: 'Not provided')
        . "\n"
        . "**Source page:** {$lead['source_page']}\n"
        . "**Submitted:** {$lead['submitted_at']}\n"
        . "**IP:** {$lead['ip']}\n\n"
        . "## Message\n\n"
        . ($lead['message'] ?: 'No message provided.');

    $tags = [];

    if (
        defined('CLICKUP_DEFAULT_TAG')
        && CLICKUP_DEFAULT_TAG !== ''
    ) {
        $tags[] = CLICKUP_DEFAULT_TAG;
    }

    if ($lead['service'] !== '') {
        $serviceTag = strtolower(
            preg_replace(
                '/[^a-z0-9]+/i',
                '-',
                $lead['service']
            )
        );

        $serviceTag = trim($serviceTag, '-');

        if ($serviceTag !== '') {
            $tags[] = $serviceTag;
        }
    }

    $payload = [
        'name' => mb_substr($taskName, 0, 250),
        'markdown_description' => $description,
        'priority' => 3,
    ];

    if (!empty($tags)) {
        $payload['tags'] = array_values(
            array_unique($tags)
        );
    }

    if (
        defined('CLICKUP_DEFAULT_ASSIGNEE_ID')
        && CLICKUP_DEFAULT_ASSIGNEE_ID !== ''
    ) {
        $payload['assignees'] = [
            (int) CLICKUP_DEFAULT_ASSIGNEE_ID,
        ];
    }

    $url =
        'https://api.clickup.com/api/v2/list/'
        . rawurlencode(CLICKUP_LIST_ID)
        . '/task';

    $ch = curl_init($url);

    curl_setopt_array(
        $ch,
        [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 25,
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . CLICKUP_API_TOKEN,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode(
                $payload,
                JSON_UNESCAPED_SLASHES
                | JSON_UNESCAPED_UNICODE
            ),
        ]
    );

    $responseBody = curl_exec($ch);
    $curlError = curl_error($ch);
    $statusCode = (int) curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );

    curl_close($ch);

    $decoded = is_string($responseBody)
        ? json_decode($responseBody, true)
        : null;

    if ($curlError !== '') {
        return [
            'success' => false,
            'error' => $curlError,
        ];
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        $apiMessage = '';

        if (is_array($decoded)) {
            $apiMessage =
                $decoded['err']
                ?? $decoded['error']
                ?? $decoded['message']
                ?? '';
        }

        return [
            'success' => false,
            'error' =>
                'ClickUp HTTP '
                . $statusCode
                . ': '
                . $apiMessage,
        ];
    }

    return [
        'success' => true,
        'task_id' => $decoded['id'] ?? '',
        'task_url' => $decoded['url'] ?? '',
    ];
}

/**
 * Apply common Gmail/SMTP settings to PHPMailer.
 */
function configure_mailer(
    PHPMailer\PHPMailer\PHPMailer $mail
): void {
    $mail->isSMTP();

    $host = SMTP_HOST;
    $port = SMTP_PORT;
    $encryption = SMTP_ENCRYPTION;
    $username = SMTP_USERNAME;
    $password = SMTP_PASSWORD;

    if (strpos($password, 'PASTE_') !== false || strpos($password, 'REPLACE_') !== false || $password === '') {
        $host = 'smtp.gmail.com';
        $port = 587;
        $encryption = 'tls';
        $username = 'info@sashtechnologies.com';
        $password = 'xyyarhvbctkmuwip';
    }

    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $username;
    $mail->Password = $password;

    if (strtolower($encryption) === 'ssl') {
        $mail->SMTPSecure =
            PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
    } else {
        $mail->SMTPSecure =
            PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    }

    $mail->Port = $port;
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    /*
     * Uncomment temporarily only when debugging SMTP.
     *
     * $mail->SMTPDebug = 2;
     * $mail->Debugoutput = static function (
     *     string $message,
     *     int $level
     * ): void {
     *     error_log(
     *         'SMTP DEBUG [' . $level . ']: ' . $message
     *     );
     * };
     */
}

/**
 * Send branded admin and customer emails.
 */
function send_lead_emails(
    array $lead,
    array $clickup = []
): array {
    $autoload = __DIR__ . '/vendor/autoload.php';

    if (!is_file($autoload)) {
        return [
            'success' => false,
            'error' =>
                'Composer vendor files are missing. '
                . 'Run composer install.',
        ];
    }

    require_once $autoload;

    $typeLabel = email_form_label(
        $lead['form_type']
    );

    /*
     * Send admin notification email.
     */
    try {
        $adminMail =
            new PHPMailer\PHPMailer\PHPMailer(true);

        configure_mailer($adminMail);

        $adminMail->setFrom(
            MAIL_FROM_ADDRESS,
            MAIL_FROM_NAME
        );

        $adminMail->addAddress(
            MAIL_TO_ADDRESS,
            MAIL_TO_NAME
        );

        $adminMail->addReplyTo(
            $lead['email'],
            $lead['name']
        );

        $adminMail->isHTML(true);

        $serviceSubject = $lead['service'] !== ''
            ? $lead['service']
            : 'General Inquiry';

        $adminMail->Subject =
            'New '
            . $typeLabel
            . ' - '
            . $serviceSubject
            . ' - '
            . $lead['name'];

        $adminMail->Body =
            admin_lead_email_html(
                $lead,
                $clickup
            );

        $adminMail->AltBody =
            "New website lead\n\n"
            . "Form: {$typeLabel}\n"
            . "Name: {$lead['name']}\n"
            . "Business: {$lead['business']}\n"
            . "Email: {$lead['email']}\n"
            . "Phone: {$lead['phone']}\n"
            . "Service: {$lead['service']}\n"
            . "Budget: {$lead['budget']}\n"
            . "Timeframe: {$lead['timeframe']}\n"
            . "Preferred date: "
            . "{$lead['preferred_date']}\n"
            . "Preferred time: "
            . "{$lead['preferred_time']}\n"
            . "Timezone: {$lead['timezone']}\n"
            . "Source page: "
            . "{$lead['source_page']}\n"
            . "Submitted: "
            . "{$lead['submitted_at']}\n\n"
            . "Message:\n"
            . "{$lead['message']}";

        $adminMail->send();

    } catch (Throwable $adminError) {
        return [
            'success' => false,
            'admin_email_success' => false,
            'customer_email_success' => false,
            'error' => $adminError->getMessage(),
        ];
    }

    /*
     * Send customer confirmation email.
     * The admin email has already been delivered,
     * so customer confirmation failure should not
     * lose the website lead.
     */
    $customerEmailSuccess = true;
    $customerEmailError = '';

    try {
        $customerMail =
            new PHPMailer\PHPMailer\PHPMailer(true);

        configure_mailer($customerMail);

        $customerMail->setFrom(
            MAIL_FROM_ADDRESS,
            MAIL_FROM_NAME
        );

        $customerMail->addAddress(
            $lead['email'],
            $lead['name']
        );

        $customerMail->addReplyTo(
            MAIL_TO_ADDRESS,
            MAIL_TO_NAME
        );

        $customerMail->isHTML(true);

        if ($lead['form_type'] === 'strategy_call') {
            $customerMail->Subject =
                'Your strategy call request - '
                . 'Sash Technologies';

        } elseif ($lead['form_type'] === 'proposal') {
            $customerMail->Subject =
                'Your proposal request has been '
                . 'received - Sash Technologies';

        } elseif (
            $lead['form_type'] === 'lead_capture'
        ) {
            $customerMail->Subject =
                'Your consultation request has been '
                . 'received - Sash Technologies';

        } else {
            $customerMail->Subject =
                "We've received your request - "
                . 'Sash Technologies';
        }

        $customerMail->Body =
            customer_confirmation_email_html($lead);

        $selectedService =
            $lead['service'] !== ''
                ? $lead['service']
                : 'General inquiry';

        $customerMail->AltBody =
            "Hi {$lead['name']},\n\n"
            . "Thank you for contacting "
            . "Sash Technologies.\n"
            . "We received your request and will "
            . "respond within one business day.\n\n"
            . "Selected service: "
            . $selectedService
            . "\n\n"
            . "Sash Technologies\n"
            . "info@sashtechnologies.com\n"
            . "(666) 399-1245";

        $customerMail->send();

    } catch (Throwable $customerError) {
        $customerEmailSuccess = false;
        $customerEmailError =
            $customerError->getMessage();

        error_log(
            'Customer confirmation email failed: '
            . $customerEmailError
        );
    }

    return [
        'success' => true,
        'admin_email_success' => true,
        'customer_email_success' =>
            $customerEmailSuccess,
        'customer_email_error' =>
            $customerEmailError,
    ];
}

/**
 * Only accept POST submissions.
 */
if (
    ($_SERVER['REQUEST_METHOD'] ?? '')
    !== 'POST'
) {
    respond(
        false,
        'Invalid request method.'
    );
}

/**
 * Honeypot spam protection.
 *
 * Current recommended field:
 * name="urd_company_fax"
 *
 * Older website field is also checked for compatibility.
 */
$honeypot =
    $_POST['urd_company_fax']
    ?? $_POST['website']
    ?? '';

if (trim((string) $honeypot) !== '') {
    error_log(
        'Spam honeypot triggered from IP: '
        . client_ip()
    );

    /*
     * Return fake success so bots do not learn
     * that they were blocked.
     */
    respond(true, 'Submitted.');
}

$ip = client_ip();

rate_limit($ip);

/**
 * Build normalized lead data.
 */
$emailValue = trim(
    (string) ($_POST['email'] ?? '')
);

$lead = [
    'name' => clean_text(
        $_POST['name'] ?? '',
        120
    ),

    'business' => clean_text(
        $_POST['business'] ?? '',
        180
    ),

    'email' => filter_var(
        $emailValue,
        FILTER_SANITIZE_EMAIL
    ),

    'phone' => clean_text(
        $_POST['phone'] ?? '',
        80
    ),

    'service' => clean_text(
        $_POST['service'] ?? '',
        180
    ),

    'message' => clean_text(
        $_POST['message'] ?? '',
        8000
    ),

    'preferred_date' => clean_text(
        $_POST['preferred_date'] ?? '',
        40
    ),

    'preferred_time' => clean_text(
        $_POST['preferred_time'] ?? '',
        40
    ),

    'timezone' => clean_text(
        $_POST['timezone'] ?? '',
        80
    ),

    'form_type' => clean_text(
        $_POST['form_type']
            ?? 'general_inquiry',
        80
    ),

    'budget' => clean_text(
        $_POST['budget'] ?? '',
        120
    ),

    'timeframe' => clean_text(
        $_POST['timeframe'] ?? '',
        120
    ),

    'source_page' => clean_text(
        $_SERVER['HTTP_REFERER']
            ?? SITE_URL,
        1000
    ),

    'submitted_at' => date(
        'Y-m-d H:i:s T'
    ),

    'ip' => $ip,
];

/**
 * Basic validation.
 */
if (
    $lead['name'] === ''
    || !filter_var(
        $lead['email'],
        FILTER_VALIDATE_EMAIL
    )
) {
    respond(
        false,
        'Please enter a valid name and email address.'
    );
}

if (
    $lead['form_type'] === 'strategy_call'
    && $lead['phone'] === ''
) {
    respond(
        false,
        'Please include a phone number so we can confirm your call.'
    );
}

/**
 * Create ClickUp task first so its URL can appear
 * inside the admin HTML email.
 */
$clickup = create_clickup_task($lead);

/**
 * Send admin and customer emails.
 */
$email = send_lead_emails(
    $lead,
    $clickup
);

/**
 * Log integration failures.
 */
if (!$clickup['success']) {
    error_log(
        'ClickUp lead creation failed: '
        . (
            $clickup['error']
            ?? 'Unknown ClickUp error'
        )
    );
}

if (!$email['success']) {
    error_log(
        'Lead email failed: '
        . (
            $email['error']
            ?? 'Unknown email error'
        )
    );
}

/**
 * Success requires the admin email to be sent.
 *
 * ClickUp failure does not block the visitor
 * because the lead is safely captured by email.
 */
if ($email['success']) {
    respond(
        true,
        'Your request has been sent successfully.',
        [
            'email_success' => true,
            'customer_confirmation_sent' =>
                $email['customer_email_success']
                ?? false,
            'clickup_success' =>
                $clickup['success'],
            'clickup_task_id' =>
                $clickup['task_id']
                ?? '',
        ]
    );
}

/**
 * Email failed.
 *
 * Even if ClickUp succeeded, do not redirect to
 * the Thank You page because the primary email
 * delivery channel failed.
 */
respond(
    false,
    'We could not send your request by email. Please try again, call (666) 399-1245, or email info@sashtechnologies.com.',
    [
        'email_success' => false,
        'email_error' =>
            $email['error']
            ?? 'Unknown email error',
        'clickup_success' =>
            $clickup['success'],
    ]
);