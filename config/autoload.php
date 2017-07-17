<?php

function autoload($class) {
	if(file_exists(CLASS_PATH.$class.'.class.php')) {
		require_once(CLASS_PATH.$class.'.class.php');
	} elseif(file_exists(CLASS_PATH.'bootstrap/'.$class.'.class.php')) {
		require_once(CLASS_PATH.'bootstrap/'.$class.'.class.php');
	} elseif(file_exists(CLASS_PATH.'chart/'.$class.'.class.php')) {
		require_once(CLASS_PATH.'chart/'.$class.'.class.php');
	} else {
		exit("The file \"".$class.".class.php\" is missing.");
	}
}

spl_autoload_register("autoload");
?>