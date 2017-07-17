<?php
define('SESSION_KEY', '3##%wPCVYTjXU=GJ9E9STSQ2k@jzsBpM');
define('SESSION_NAME', 'MY_SESSION');
define('SESSION_PREFIX', 'MVC_');

define('COOKIE_LIFETIME', 0);
define('COOKIE_PATH', ini_get('session.cookie_path'));
define('COOKIE_DOMAIN', ini_get('session.cookie_domain'));
define('COOKIE_SECURE', isset($_SERVER['HTTPS']));
define('COOKIE_HTTPONLY', true);
?>