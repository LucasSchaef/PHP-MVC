<?php
function IsArrayEmpty(array $array) {
	if(count($array) == 0)
		return true;
	else
		return false;
}

function getCurrentPathArray() {
	if(isset($_GET['url'])) {
		$url = rtrim($_GET['url'], "/");
		$url = explode("/", $url);
		return $url;
	} else {
		return array("Index");
	}
}

function getCurrentPath() {
	$path = getCurrentPathArray();
	return URL.implode("/",$path)."/";
}

function getCurrentController() {
	$controller = getCurrentPathArray();
	return $controller[0];
}

function getCurrentAction() {
	$action = getCurrentPathArray();
	if(isset($action[1])) {
		return $action[1];	
	}
	return false;
}

function getCurrentParams() {
	$params = getCurrentPathArray();
	return array_slice($params, 2, count($params));	
}

function piane() {
	$keys = func_get_args();
	foreach($keys as $key) {
		if(!isset($_POST[$key]) OR empty($_POST[$key])) {
			return false;
		}
	}
	return true;
}

function giane() {
	$keys = func_get_args();
	foreach($keys as $key) {
		if(!isset($_GET[$key]) OR empty($_GET[$key])) {
			return false;
		}
	}
	return true;
}

function riane() {
	$keys = func_get_args();
	foreach($keys as $key) {
		if(!isset($_REQUEST[$key]) OR empty($_REQUEST[$key])) {
			return false;
		}
	}
	return true;
}

function siane() {
	$keys = func_get_args();
	foreach($keys as $key) {
		if(!isset($_SESSION[$key]) OR empty($_SESSION[$key])) {
			return false;
		}
	}
	return true;
}

function mkCrudList(array $result, array $head, $crud_id, $show_crud_id = false) {
	$list = new niceList($head, true, $crud_id, getCurrentPath());
	$list->show_crud_id = $show_crud_id;
	if(count($result)>0) {
		foreach($result as $row) {
			$list->addRow($row);	
		}
	}
	return $list->write();
}
?>