<?php

class Page {
	public static function title() {
		if(isset($_GET['url'])) {
			$url = self::getPath();
			echo APPLICATION_NAME.' >> '.implode('>>', $url);
		} else {
			echo APPLICATION_NAME;
		}
	}
	
	public static function breadcrumb() {
		echo '<ol class="breadcrumb">';
		echo '<li><a href="'.URL.'">START</a></li>';
		if(isset($_GET['url'])) {
			$url = self::getPath();
			$links = self::getLinksFromURLarray($url);
			for($i=0;$i<count($url);$i++) {
				if($i == (count($url)-1)) {
					echo '<li class="active">'.$url[$i].'</li>';
				} else {
					echo '<li><a href="'.$links[$i].'/">'.$url[$i].'</a></li>';
				}
			}
		} 
		echo '</ol>';
	}
	
	public static function getLinksFromURLarray(array $url) {
		$links = array();
		for($i=0;$i<count($url);$i++) {
			if($i>0) {
				for($u=0;$u<$i;$u++) {
					$before[] = $url[$u];
				}
				$links[] = URL.implode("/", $before)."/".$url[$i];
			} else {
				$links[] = URL.$url[$i];	
			}
		}
		
		return $links;
	}
	
	public static function getPath() {
		if(isset($_GET['url'])) {
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
			$url = explode('/', strtoupper($url));
			if(count($url)>2) {
				array_pop($url);
			}
			return $url;
		} 
	}
}

?>