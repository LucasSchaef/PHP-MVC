<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

define('DEFAULT_USERGROUP', 2);

define('DEFAULT_FA_CLASS', 'puzzle-piece');

define('APPLICATION_NAME', 'PHP-MVC');
define('PREFIX', 'mvc_');
define('URL', 'http://localhost/PHP-MVC/');

define('CLASS_PATH', 'class/');
define('CONTROLLER_PATH', 'Controller/');
define('MODELS_PATH', 'models/');
define('VIEWS_PATH', 'views/');
define("AVATAR_PATH", 'img/avatars/');

define('SCRIPT_PATH', 'js/');
define('STYLE_PATH', 'css/');

define('CONTROLLER_TMPL_PATH', 'views/_templates/mvc/Controller.php');
define('MODEL_TMPL_PATH', 'views/_templates/mvc/model.php');
define('VIEW_TMPL_PATH', 'views/_templates/mvc/view.php');

// Session-Hashing
define('HASH_ALGO', MCRYPT_RIJNDAEL_128);
define('HASH_TYPE', MCRYPT_MODE_ECB);

// MAIL-Config
define('REGISTER_EMAIL_FROM', "admin@applicationnssss.com");

require_once('config/session.config.php');
require_once('config/database.config.php');
require_once('config/feedback.config.php');
?>