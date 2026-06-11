<?php
// Mail/application settings used by helpers/Email.php.
if (!function_exists('mail_config_value')) {
    function mail_config_value($key, $default = '') {
        $value = getenv($key);
        return ($value === false || $value === '') ? $default : $value;
    }
}

if (!defined('APP_NAME')) {
    define('APP_NAME', 'GlobeTrek Adventures');
}

if (!defined('STAFF_EMAIL')) {
    define('STAFF_EMAIL', 'darany91ahilen@gmail.com');
}

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php')), '/');

    define('BASE_URL', $protocol . '://' . $host . $scriptDir);
}

if (!defined('SMTP_ENABLED')) {
    define('SMTP_ENABLED', filter_var(mail_config_value('SMTP_ENABLED', true), FILTER_VALIDATE_BOOLEAN));
}

if (!defined('SMTP_HOST')) {
    define('SMTP_HOST', mail_config_value('SMTP_HOST', 'smtp.gmail.com'));
}

if (!defined('SMTP_PORT')) {
    define('SMTP_PORT', (int)mail_config_value('SMTP_PORT', 587));
}

if (!defined('SMTP_USERNAME')) {
    define('SMTP_USERNAME', mail_config_value('SMTP_USERNAME', 'darany91ahilen@gmail.com'));
}

if (!defined('SMTP_PASSWORD')) {
    define('SMTP_PASSWORD', mail_config_value('SMTP_PASSWORD', 'yogcbbmtxpxldeyx'));
}

if (!defined('SMTP_SECURE')) {
    define('SMTP_SECURE', mail_config_value('SMTP_SECURE', SMTP_PORT === 465 ? 'ssl' : 'tls'));
}

if (!defined('SMTP_DEBUG')) {
    define('SMTP_DEBUG', (int)mail_config_value('SMTP_DEBUG', 0));
}

if (!defined('SMTP_FROM_EMAIL')) {
    define('SMTP_FROM_EMAIL', mail_config_value('SMTP_FROM_EMAIL', 'darany91ahilen@gmail.com'));
}

if (!defined('SMTP_FROM_NAME')) {
    define('SMTP_FROM_NAME', mail_config_value('SMTP_FROM_NAME', 'GlobeTrek Adventures'));
}
