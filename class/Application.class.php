<?php

class Application {
	private $url_controller, $url_action, $url_parameters, $controller;
	
	public function __construct() {
		$this->splitURL();
		
		if($this->url_controller) {
			if(file_exists(CONTROLLER_PATH.$this->url_controller.'.php')) {
				require_once(CONTROLLER_PATH.$this->url_controller.'.php');
				$this->controller = new $this->url_controller();
				if($this->url_action) {
					if(method_exists($this->controller, $this->url_action) OR method_exists($this->controller, "__call")) {
						if(is_array($this->url_parameters)) {
							$this->controller->{$this->url_action}($this->url_parameters);	
						} else {
							$this->controller->{$this->url_action}();
						}
					} else {
						header('Location: '.URL.'error/index');	
					}
				} else {
					$this->controller->index();	
				}
			} else {
				header('Location: '.URL.'error/index');	
			}
		} else {
			require_once(CONTROLLER_PATH.'index.php');
			$controller = new Index();
			$controller->index();
		}
	}

	private function splitURL() {
		if(isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', $url);
			
			$this->url_controller = (isset($url[0]) ? $url[0] : null);
			$this->url_action  = (isset($url[1]) ? $url[1] : null);
			if(count($url) > 2) {
				for($i=2;$i<count($url);$i++) {
					$this->url_parameters[] = $url[$i];
				}
			}
		}
	}
	
}