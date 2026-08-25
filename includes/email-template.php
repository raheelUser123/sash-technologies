<?php

declare(strict_types=1);

/**
 * Sash Technologies responsive HTML email templates.
 */

function email_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function email_form_label(string $formType): string
{
    $labels = [
        'strategy_call'   => 'Strategy Call Request',
        'lead_capture'    => 'Growth Consultation Request',
        'proposal'        => 'Proposal Request',
        'general_inquiry' => 'General Website Inquiry',
    ];

    return $labels[$formType] ?? ucwords(str_replace('_', ' ', $formType));
}

function email_service_message(array $lead): string
{
    $service = strtolower(trim((string) ($lead['service'] ?? '')));

    $messages = [
        'web design' => 'Our web design team will review your goals, desired features, branding requirements, and launch timeline.',
        'web hosting' => 'Our technical team will review your hosting, performance, security, migration, and maintenance requirements.',
        'e-commerce consulting' => 'Our e-commerce team will assess your store, customer journey, integrations, conversion goals, and operational needs.',
        'social media marketing' => 'Our marketing team will review your audience, platforms, content requirements, campaign goals, and growth opportunities.',
        'logo service' => 'Our branding team will review your visual direction, audience, preferred styles, and business positioning.',
        'graphic design' => 'Our creative team will review your design requirements, formats, brand guidelines, and intended use.',
        'mobile design' => 'Our UI/UX team will review your mobile product, user flows, screens, interactions, and technical requirements.',
        'presentation design' => 'Our presentation team will review your content, audience, visual direction, and delivery format.',
        'public relations' => 'Our communications team will review your objectives, audience, positioning, and media opportunities.',
        'telemarketing & telesales' => 'Our growth team will review your target audience, scripts, lead sources, sales process, and campaign objectives.',
        'business consulting' => 'Our consulting team will review your challenges, processes, growth goals, and strategic priorities.',
        'project management' => 'Our project team will review your scope, resources, milestones, communication needs, and delivery timeline.',
        'recruiting' => 'Our recruiting team will review your open roles, experience requirements, hiring timeline, and screening process.',
        'statistical data analysis' => 'Our analysis team will review your data sources, research questions, methodology, and reporting requirements.',
        'writing & editing services' => 'Our editorial team will review your content, audience, tone, format, and publishing objectives.',
        'resume writing' => 'Our resume team will review your experience, target roles, achievements, and professional positioning.',
        'reading & writing tutoring' => 'Our education team will review the learner’s goals, current level, preferred schedule, and areas requiring support.',
        'legal document preparation' => 'Our document team will review the required document type, available information, formatting, and deadline.',
        'accounting' => 'Our accounting team will review your records, reporting needs, business structure, and ongoing support requirements.',
        'business tax preparation' => 'Our tax team will review your business structure, available records, filing requirements, and deadlines.',
        'individual tax preparation' => 'Our tax team will review your income documents, deductions, filing status, and submission requirements.',
    ];

    return $messages[$service]
        ?? 'Our team will review the information you submitted and prepare the most appropriate next steps for your request.';
}

function email_detail_row(string $label, string $value): string
{
    if (trim($value) === '') {
        $value = 'Not provided';
    }

    return '
        <tr>
            <td style="
                padding:12px 14px;
                width:34%;
                color:#64748b;
                font-size:13px;
                line-height:20px;
                vertical-align:top;
                border-bottom:1px solid #e8edf5;
            ">
                ' . email_escape($label) . '
            </td>

            <td style="
                padding:12px 14px;
                color:#111827;
                font-size:14px;
                font-weight:600;
                line-height:20px;
                vertical-align:top;
                border-bottom:1px solid #e8edf5;
                word-break:break-word;
            ">
                ' . nl2br(email_escape($value)) . '
            </td>
        </tr>
    ';
}

function email_button(string $url, string $label, bool $secondary = false): string
{
    $background = $secondary
        ? '#ffffff'
        : 'linear-gradient(135deg,#04c8dc 0%,#3677ff 48%,#7c5cff 100%)';

    $color = $secondary ? '#172554' : '#ffffff';
    $border = $secondary ? '1px solid #cdd8ee' : '1px solid transparent';

    return '
        <a href="' . email_escape($url) . '"
           style="
                display:inline-block;
                margin:5px;
                padding:14px 22px;
                border-radius:10px;
                border:' . $border . ';
                background:' . $background . ';
                color:' . $color . ';
                font-family:Arial,Helvetica,sans-serif;
                font-size:14px;
                font-weight:700;
                line-height:18px;
                text-decoration:none;
                box-shadow:0 10px 28px rgba(43,107,255,.20);
           ">
            ' . email_escape($label) . '
        </a>
    ';
}

function email_layout(
    string $previewText,
    string $eyebrow,
    string $heading,
    string $intro,
    string $content,
    string $footerNote = ''
): string {
    $siteUrl = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://sashtechnologies.com';

    /*
     * Replace this placeholder image whenever your final email logo is ready.
     * Recommended size: around 320x80 pixels with transparent background.
     */
    $logoUrl = $siteUrl . '/assets/images/urdigilogo.png';

    return '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>' . email_escape($heading) . '</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#eef3fb;
    font-family:Poppins,Arial,Helvetica,sans-serif;
    color:#111827;
">
    <div style="
        display:none;
        max-height:0;
        overflow:hidden;
        opacity:0;
        color:transparent;
    ">
        ' . email_escape($previewText) . '
    </div>

    <table role="presentation"
           width="100%"
           cellspacing="0"
           cellpadding="0"
           border="0"
           style="width:100%;background:#eef3fb;">
        <tr>
            <td align="center" style="padding:32px 12px;">

                <table role="presentation"
                       width="100%"
                       cellspacing="0"
                       cellpadding="0"
                       border="0"
                       style="
                            width:100%;
                            max-width:680px;
                            background:#ffffff;
                            border-radius:20px;
                            overflow:hidden;
                            box-shadow:0 22px 60px rgba(17,34,72,.12);
                       ">

                    <tr>
                        <td style="
                            padding:28px 32px 52px;
                            background-color:#09132d;
                            background-image:
                                radial-gradient(circle at 10% 20%,rgba(0,224,224,.30),transparent 34%),
                                radial-gradient(circle at 90% 10%,rgba(100,88,255,.40),transparent 38%),
                                linear-gradient(135deg,#071128 0%,#102653 55%,#17163e 100%);
                        ">
                            <table role="presentation"
                                   width="100%"
                                   cellspacing="0"
                                   cellpadding="0"
                                   border="0">
                                <tr>
                                    <td>
                                        <img src="' . email_escape($logoUrl) . '"
                                             width="180"
                                             alt="Sash Technologies"
                                             style="
                                                display:block;
                                                width:180px;
                                                max-width:100%;
                                                height:auto;
                                                border:0;
                                             ">
                                    </td>

                                    <td align="right" style="
                                        color:#b9c9e8;
                                        font-size:12px;
                                        font-weight:700;
                                        letter-spacing:.7px;
                                        text-transform:uppercase;
                                    ">
                                        Digital solutions built for growth
                                    </td>
                                </tr>
                            </table>

                            <div style="
                                margin-top:34px;
                                color:#63e5ef;
                                font-size:12px;
                                font-weight:700;
                                letter-spacing:1.4px;
                                text-transform:uppercase;
                            ">
                                ' . email_escape($eyebrow) . '
                            </div>

                            <h1 style="
                                margin:12px 0 12px;
                                color:#ffffff;
                                font-family:Arial,Helvetica,sans-serif;
                                font-size:34px;
                                line-height:42px;
                                font-weight:800;
                                letter-spacing:-.5px;
                            ">
                                ' . email_escape($heading) . '
                            </h1>

                            <p style="
                                margin:0;
                                max-width:560px;
                                color:#c8d5ee;
                                font-size:15px;
                                line-height:25px;
                            ">
                                ' . email_escape($intro) . '
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 30px 30px;">
                            <div style="
                                margin-top:-25px;
                                padding:26px;
                                background:#ffffff;
                                border:1px solid #e2e9f5;
                                border-radius:16px;
                                box-shadow:0 14px 36px rgba(25,51,104,.10);
                            ">
                                ' . $content . '
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="
                            padding:26px 30px;
                            background:#f7f9fd;
                            border-top:1px solid #e7edf7;
                            text-align:center;
                        ">
                            <p style="
                                margin:0 0 7px;
                                color:#18233d;
                                font-size:14px;
                                line-height:22px;
                                font-weight:700;
                            ">
                                Sash Technologies
                            </p>

                            <p style="
                                margin:0;
                                color:#75819a;
                                font-size:12px;
                                line-height:20px;
                            ">
                                Digital strategy, web solutions, automation and business growth.
                            </p>

                            <p style="
                                margin:12px 0 0;
                                color:#75819a;
                                font-size:12px;
                                line-height:20px;
                            ">
                                <a href="' . email_escape($siteUrl) . '"
                                   style="color:#315fcf;text-decoration:none;">
                                    urdigitaltech.com
                                </a>
                                &nbsp;•&nbsp;
                                <a href="mailto:info@sashtechnologies.com"
                                   style="color:#315fcf;text-decoration:none;">
                                    info@sashtechnologies.com
                                </a>
                                &nbsp;•&nbsp;
                                <a href="tel:+17164000769"
                                   style="color:#315fcf;text-decoration:none;">
                                    (666) 399-1245
                                </a>
                            </p>

                            ' . ($footerNote !== ''
                                ? '<p style="
                                        margin:12px 0 0;
                                        color:#98a2b5;
                                        font-size:11px;
                                        line-height:18px;
                                   ">' . email_escape($footerNote) . '</p>'
                                : '') . '
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>';
}

function admin_lead_email_html(array $lead, array $clickup = []): string
{
    $typeLabel = email_form_label($lead['form_type']);
    $siteUrl = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://sashtechnologies.com';

    $details =
        email_detail_row('Form type', $typeLabel) .
        email_detail_row('Name', $lead['name']) .
        email_detail_row('Business', $lead['business']) .
        email_detail_row('Email', $lead['email']) .
        email_detail_row('Phone', $lead['phone']) .
        email_detail_row('Service', $lead['service']) .
        email_detail_row('Budget', $lead['budget']) .
        email_detail_row('Timeframe', $lead['timeframe']) .
        email_detail_row('Preferred date', $lead['preferred_date']) .
        email_detail_row('Preferred time', $lead['preferred_time']) .
        email_detail_row('Timezone', $lead['timezone']) .
        email_detail_row('Source page', $lead['source_page']) .
        email_detail_row('Submitted', $lead['submitted_at']) .
        email_detail_row('IP address', $lead['ip']);

    $clickupButton = '';

    if (!empty($clickup['task_url'])) {
        $clickupButton = email_button(
            $clickup['task_url'],
            'Open lead in ClickUp'
        );
    }

    $content = '
        <div style="
            display:inline-block;
            margin-bottom:18px;
            padding:7px 12px;
            border-radius:999px;
            background:#e7fafd;
            color:#057887;
            font-size:12px;
            font-weight:700;
        ">
            New website submission
        </div>

        <h2 style="
            margin:0 0 8px;
            color:#111827;
            font-size:21px;
            line-height:29px;
        ">
            Lead details
        </h2>

        <p style="
            margin:0 0 20px;
            color:#68748a;
            font-size:14px;
            line-height:23px;
        ">
            A new visitor submitted the ' . email_escape($typeLabel) . ' form.
        </p>

        <table role="presentation"
               width="100%"
               cellspacing="0"
               cellpadding="0"
               border="0"
               style="
                    width:100%;
                    border:1px solid #e4eaf4;
                    border-radius:12px;
                    overflow:hidden;
                    border-collapse:separate;
                    border-spacing:0;
               ">
            ' . $details . '
        </table>

        <div style="
            margin-top:22px;
            padding:20px;
            border-radius:12px;
            background:#f4f7fc;
            border-left:4px solid #3477ff;
        ">
            <div style="
                margin-bottom:8px;
                color:#1a2540;
                font-size:13px;
                font-weight:800;
                letter-spacing:.5px;
                text-transform:uppercase;
            ">
                Message
            </div>

            <div style="
                color:#4c5870;
                font-size:14px;
                line-height:24px;
                white-space:pre-line;
            ">
                ' . nl2br(email_escape(
                    $lead['message'] !== ''
                        ? $lead['message']
                        : 'No message was provided.'
                )) . '
            </div>
        </div>

        <div style="margin-top:22px;text-align:center;">
            ' . $clickupButton . '
            ' . email_button(
                'mailto:' . rawurlencode($lead['email']),
                'Reply to lead',
                true
            ) . '
            ' . email_button(
                $siteUrl . '/schedule.php',
                'Open scheduling page',
                true
            ) . '
        </div>
    ';

    return email_layout(
        'A new website lead has been received.',
        $typeLabel,
        'New lead received',
        'Review the contact information and follow up with the prospect as soon as possible.',
        $content
    );
}

function customer_confirmation_email_html(array $lead): string
{
    $typeLabel = email_form_label($lead['form_type']);
    $siteUrl = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://sashtechnologies.com';
    $firstName = trim(explode(' ', $lead['name'])[0] ?? $lead['name']);

    $service = $lead['service'] !== ''
        ? $lead['service']
        : 'General inquiry';

    $extraDetails = '';

    if ($lead['form_type'] === 'strategy_call') {
        $extraDetails = '
            <div style="
                margin-top:18px;
                padding:18px;
                background:#eff8ff;
                border:1px solid #d5eafb;
                border-radius:12px;
            ">
                <div style="
                    margin-bottom:10px;
                    color:#1d4f91;
                    font-size:13px;
                    font-weight:800;
                    text-transform:uppercase;
                    letter-spacing:.5px;
                ">
                    Requested appointment
                </div>

                <div style="
                    color:#263653;
                    font-size:14px;
                    line-height:24px;
                ">
                    <strong>Date:</strong> ' .
                    email_escape($lead['preferred_date'] ?: 'To be confirmed') .
                    '<br>

                    <strong>Time:</strong> ' .
                    email_escape($lead['preferred_time'] ?: 'To be confirmed') .
                    '<br>

                    <strong>Timezone:</strong> ' .
                    email_escape($lead['timezone'] ?: 'Not provided') .
                    '
                </div>
            </div>
        ';
    }

    $content = '
        <div style="
            width:56px;
            height:56px;
            margin:0 auto 18px;
            border-radius:50%;
            background:linear-gradient(135deg,#04c8dc,#3477ff);
            color:#ffffff;
            font-size:28px;
            font-weight:800;
            line-height:56px;
            text-align:center;
            box-shadow:0 12px 28px rgba(52,119,255,.25);
        ">
            ✓
        </div>

        <h2 style="
            margin:0 0 10px;
            color:#111827;
            font-size:23px;
            line-height:31px;
            text-align:center;
        ">
            Thank you, ' . email_escape($firstName) . '!
        </h2>

        <p style="
            margin:0 auto 24px;
            max-width:510px;
            color:#66728a;
            font-size:14px;
            line-height:24px;
            text-align:center;
        ">
            We have successfully received your request. A member of the Sash Technologies team will review it and contact you within one business day.
        </p>

        <div style="
            padding:20px;
            border-radius:13px;
            background:#f5f8fd;
            border:1px solid #e2eaf5;
        ">
            <div style="
                margin-bottom:6px;
                color:#7c879d;
                font-size:12px;
                font-weight:700;
                text-transform:uppercase;
                letter-spacing:.7px;
            ">
                Selected service
            </div>

            <div style="
                color:#17213a;
                font-size:18px;
                line-height:26px;
                font-weight:800;
            ">
                ' . email_escape($service) . '
            </div>

            <p style="
                margin:12px 0 0;
                color:#68748b;
                font-size:13px;
                line-height:22px;
            ">
                ' . email_escape(email_service_message($lead)) . '
            </p>
        </div>

        ' . $extraDetails . '

        <div style="margin-top:26px;">
            <h3 style="
                margin:0 0 16px;
                color:#18213a;
                font-size:17px;
                line-height:24px;
                text-align:center;
            ">
                What happens next?
            </h3>

            <table role="presentation"
                   width="100%"
                   cellspacing="0"
                   cellpadding="0"
                   border="0">
                <tr>
                    <td width="25%" align="center" style="padding:7px;">
                        <div style="
                            width:38px;
                            height:38px;
                            margin:0 auto 8px;
                            border-radius:50%;
                            background:#e8f8fb;
                            color:#088295;
                            line-height:38px;
                            font-weight:800;
                        ">1</div>
                        <div style="
                            color:#1f2b44;
                            font-size:12px;
                            font-weight:700;
                        ">Review</div>
                    </td>

                    <td width="25%" align="center" style="padding:7px;">
                        <div style="
                            width:38px;
                            height:38px;
                            margin:0 auto 8px;
                            border-radius:50%;
                            background:#ebf1ff;
                            color:#356be0;
                            line-height:38px;
                            font-weight:800;
                        ">2</div>
                        <div style="
                            color:#1f2b44;
                            font-size:12px;
                            font-weight:700;
                        ">Consult</div>
                    </td>

                    <td width="25%" align="center" style="padding:7px;">
                        <div style="
                            width:38px;
                            height:38px;
                            margin:0 auto 8px;
                            border-radius:50%;
                            background:#f0ebff;
                            color:#7455d8;
                            line-height:38px;
                            font-weight:800;
                        ">3</div>
                        <div style="
                            color:#1f2b44;
                            font-size:12px;
                            font-weight:700;
                        ">Plan</div>
                    </td>

                    <td width="25%" align="center" style="padding:7px;">
                        <div style="
                            width:38px;
                            height:38px;
                            margin:0 auto 8px;
                            border-radius:50%;
                            background:#eaf9f0;
                            color:#18864c;
                            line-height:38px;
                            font-weight:800;
                        ">4</div>
                        <div style="
                            color:#1f2b44;
                            font-size:12px;
                            font-weight:700;
                        ">Start</div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top:26px;text-align:center;">
            ' . email_button(
                $siteUrl . '/schedule.php',
                'Book a strategy call'
            ) . '

            ' . email_button(
                $siteUrl . '/services.php',
                'Explore our services',
                true
            ) . '
        </div>

        <p style="
            margin:24px 0 0;
            color:#8993a7;
            font-size:12px;
            line-height:20px;
            text-align:center;
        ">
            Reference: ' . email_escape($typeLabel) . ' submitted on ' .
            email_escape($lead['submitted_at']) . '
        </p>
    ';

    $heading = $lead['form_type'] === 'strategy_call'
        ? 'Your call request is received'
        : 'We received your request';

    return email_layout(
        'Thank you for contacting Sash Technologies.',
        $typeLabel,
        $heading,
        'Your request has been safely received and our team will be in touch shortly.',
        $content,
        'This is an automated confirmation message. You may reply directly to this email if you need to add more details.'
    );
}