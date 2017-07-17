<?php
class View {
	public $loggedIn = false;
	public $user = array();
	
	public function render($filename, $render_no_head_foot = false) {
		require_once(VIEWS_PATH.'_templates/overallHeader.php');
		if($render_no_head_foot == true) {
			require_once(VIEWS_PATH.$filename.'.php');
		} else {
			require_once(VIEWS_PATH.'_templates/header.php');
			require_once(VIEWS_PATH.$filename.'.php');
			require_once(VIEWS_PATH.'_templates/footer.php');
		}
		require_once(VIEWS_PATH.'_templates/overallFooter.php');
	}
	
	public static function renderScripts($path = SCRIPT_PATH, $except = array(), $fileTypes = array('js')) {
		$files = array_diff(scandir($path), array('.', '..'));
		foreach($files as $file) {
			if(!in_array($file, $except) && in_array(pathinfo($path.$file)['extension'], $fileTypes)) {
				echo "\t\t<script src=\"".URL.$path.$file."\" language=\"javascript\" type=\"text/javascript\"></script>\n";	
			}
		}
	}
	
	public static function renderStyles($path = STYLE_PATH, $except = array(), $fileTypes = array('css')) {
		$files = array_diff(scandir($path), array('.', '..'));
		foreach($files as $file) {
			if(!in_array($file, $except) && in_array(pathinfo($path.$file)['extension'], $fileTypes)) {
				echo "\t\t<link href=\"".URL.$path.$file."\" type=\"text/css\" rel=\"stylesheet\" />\n";	
			}
		}
	}
	
	public function renderFeedbackMessages() {
		require VIEWS_PATH.'_templates/feedback.php';
		
		Session::set('feedback_positive', null);
		Session::set('feedback_negative', null);
		Session::set('feedback_warning', null);
		Session::set('feedback_info', null);
	}
	
	public function checkForActiveController($filename, $navigation_controller) {
		$split_filename = explode("/", $filename);
		$active_controller = $split_filename[0];
		
		if($active_controller == $navigation_controller) {
			return true;
		}
		
		return false;
	}
	 
	private function checkForActiveAction($filename, $navigation_action) {
		$split_filename = explode("/", $filename);
		$active_action = $split_filename[1];
		if ($active_action == $navigation_action) {
			return true;
		}
		// default return of not true
		return false;
	}
	/**
	* Checks if the passed string is the currently active controller and controller-action.
	* Useful for handling the navigation's active/non-active link.
	* @param string $filename
	* @param string $navigation_controller_and_action
	* @return bool
	*/
	private function checkForActiveControllerAndAction($filename, $navigation_controller_and_action) {
		$split_filename = explode("/", $filename);
		$active_controller = $split_filename[0];
		$active_action = $split_filename[1];
		$split_filename = explode("/", $navigation_controller_and_action);
		$navigation_controller = $split_filename[0];
		$navigation_action = $split_filename[1];
		if ($active_controller == $navigation_controller AND $active_action == $navigation_action) {
			return true;
		}
		// default return of not true
		return false;
	}
	
	public function currentPath() {
		return getCurrentPath();	
	}
	
	public function activeController() {
		$filename = $_GET['url'];
		$split_filename = explode("/", $filename);
		$active_controller = $split_filename[0];
		return $active_controller;
	}
	
	public function activeAction() {
		$filename = $_GET['url'];
		$split_filename = explode("/", $filename);
		$active_action = $split_filename[1];	
	}
}
?>