<?php
/**
 * Sash Technologies server configuration.
 *
 * Keep real passwords/tokens in config.local.php (not in Git/public downloads).
 * Copy config.local.example.php to config.local.php and enter the live values.
 */

$localConfig = __DIR__ . '/config.local.php';
if (is_file($localConfig)) {
    require $localConfig;
}

function env_value(string $key, string $default = ''): string
{
    $value = getenv($key);
    return ($value !== false && $value !== '') ? $value : $default;
}

// Business SMTP
if (!defined('SMTP_HOST')) define('SMTP_HOST', env_value('SMTP_HOST', 'smtp.gmail.com'));
if (!defined('SMTP_PORT')) define('SMTP_PORT', (int) env_value('SMTP_PORT', '587'));
if (!defined('SMTP_ENCRYPTION')) define('SMTP_ENCRYPTION', env_value('SMTP_ENCRYPTION', 'tls'));
if (!defined('SMTP_USERNAME')) define('SMTP_USERNAME', env_value('SMTP_USERNAME', ''));
if (!defined('SMTP_PASSWORD')) define('SMTP_PASSWORD', env_value('SMTP_PASSWORD', ''));

// Email identities
if (!defined('MAIL_FROM_ADDRESS')) define('MAIL_FROM_ADDRESS', env_value('MAIL_FROM_ADDRESS', ''));
if (!defined('MAIL_FROM_NAME')) define('MAIL_FROM_NAME', env_value('MAIL_FROM_NAME', ''));
if (!defined('MAIL_TO_ADDRESS')) define('MAIL_TO_ADDRESS', env_value('MAIL_TO_ADDRESS', ''));
if (!defined('MAIL_TO_NAME')) define('MAIL_TO_NAME', env_value('MAIL_TO_NAME', ''));

// ClickUp integration
if (!defined('CLICKUP_API_TOKEN')) define('CLICKUP_API_TOKEN', env_value('CLICKUP_API_TOKEN', ''));
if (!defined('CLICKUP_LIST_ID')) define('CLICKUP_LIST_ID', env_value('CLICKUP_LIST_ID', ''));
if (!defined('CLICKUP_DEFAULT_ASSIGNEE_ID')) define('CLICKUP_DEFAULT_ASSIGNEE_ID', env_value('CLICKUP_DEFAULT_ASSIGNEE_ID', ''));
if (!defined('CLICKUP_DEFAULT_TAG')) define('CLICKUP_DEFAULT_TAG', env_value('CLICKUP_DEFAULT_TAG', 'website-lead'));

// Site basics
if (!defined('SITE_URL')) define('SITE_URL', env_value('SITE_URL', 'https://sashtechnologies.com'));
if (!defined('FORM_RATE_LIMIT_SECONDS')) define('FORM_RATE_LIMIT_SECONDS', 20);
