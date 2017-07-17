<?php

class MVCModel {
	private $db;

	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function getMVCbyID($id) {
		$this->db->where('mvc_ID', $id);
		$res = $this->db->getOne('mvcs', array('mvc_name'));
		return $res['mvc_name'];
	}
	
	public function listMVCs() {
		$this->db->orderby('mvc_name', 'ASC');
		$res = $this->db->get('mvcs', NULL, array("mvc_ID", "mvc_name", "mvc_controller", "mvc_model", "mvc_view_folder", "mvc_ID"));
		return mkCrudList($res, array("ID", "Name", "Controller", "Model", "View-Folder"), "mvc_name", true);
	}
	
	public function delete($id) {
		$this->db->where('mvc_ID', $id);
		$res = $this->db->getOne('mvcs');
		$controller = $res['mvc_controller'];
		$model = $res['mvc_model'];
		$views = $res['mvc_view_folder'];
		$view_files = scandir($views);
		$view_files = array_slice($view_files, 2, count($view_files));
		if(file_exists($controller) && file_exists($model) && is_dir($views)) {
			foreach($view_files as $view) {	
				if(!unlink($views."/".$view)) {
					$_SESSION['feedback_warning'][] = MVC_COULDNT_DELETE_FILE.$views."/".$view.".";
					return false;
				}
			}
			if(!rmdir($views)) {
				$_SESSION['feedback_warning'][] = MVC_COULDNT_DELETE_FOLDER.$views.".";	
			}
			if(!unlink($controller)) {
				$_SESSION['feedback_warning'][] = MVC_COULDNT_DELETE_FILE.$controller.".";
				return false;
			}
			if(!unlink($model)) {
				$_SESSION['feedback_warning'][] = MVC_COULDNT_DELETE_FILE.$model.".";
				return false;
			}
			$this->db->where('mvc_ID', $id);
			$this->db->delete('mvcs', 1);
			return true;
		} else {
			$_SESSION['feedback_negative'][] = MVC_DEFAULT_ERROR;	
			return false;
		}
	}
	
	public function create($name) {
		  $name = htmlspecialchars($_POST['mvc_name']);
		  
		  if(piane('mvc_fa')) {
			$fa = $_POST['mvc_fa'];  
		  } else {
			$fa = DEFAULT_FA_CLASS;  
		  }
		  
		  if(piane('mvc_restricted')) {
			  $restricted = true;
		  } else {
			  $restricted = false;
		  }
		  
		  $controller = CONTROLLER_PATH.$name.".php";
		  $model = MODELS_PATH.$name."Model.php";
		  $viewFolder = VIEWS_PATH.$name;
		  $viewFile = VIEWS_PATH.$name."/index.php";
		  if(!file_exists($controller) && !file_exists($model) && !is_dir($viewFolder)) {
			  if($controller_content = $this->loadAndPrepareTMPL(CONTROLLER_TMPL_PATH, $name)) {
				  if($file = fopen($controller, "w")) {
					  fwrite($file, $controller_content);
					  if($model_content = $this->loadAndPrepareTMPL(MODEL_TMPL_PATH, $name)) {
						  if($file = fopen($model, "w")) {
							  fwrite($file, $model_content);
							  if($view_content = $this->loadAndPrepareTMPL(VIEW_TMPL_PATH, $name)) {
								  if(mkdir($viewFolder) && $file = fopen($viewFile, "w")) {
									  fwrite($file, $view_content);
									  $this->db->insert("mvcs", array("mvc_name"=>$name, 
									  									"mvc_controller"=>$controller,
																		"mvc_model"=>$model,
																		"mvc_view_folder"=>$viewFolder,
																		"mvc_fa"=>$fa,
																		"mvc_restricted"=>$restricted));
									  $_SESSION['feedback_positive'][] = MVC_CREATED;
									  return true;	
								  }
							  }
						  }
					  }
				  }
			  }
			  $_SESSION['feedback_negative'][] = MVC_CREATE_ERROR;
			  return false;
		  } else {
			  $_SESSION['feedback_negative'][] = MVC_ALREADY_EXISTS;
			  return false;	
		  }
	}
	
	private function loadAndPrepareTMPL($tmpl, $name) {
		if(file_exists($tmpl)) {
			if($file = file_get_contents($tmpl)) {
				$file = str_replace("{{NAME}}", $name, $file);
				return $file;
			}
		}
		$_SESSION['feedback_negative'][] = MVC_COULDNT_FIND_TMPL.$tmpl;
		return false;	
	}
	
	public function changeName($old, $new, $files = false) {
		return false;
		/*$modelOLD = MODELS_PATH.$old."Model.php";
		$modelNEW = MODELS_PATH.$new."Model.php";
		$viewFolderOLD = VIEWS_PATH.$old;
		$viewFolderNEW = VIEWS_PATH.$new;
		$controllerOLD = CONTROLLER_PATH.$old.".php";
		$controllerNEW = CONTROLLER_PATH.$new.".php";
		if(file_exists($modelOLD) && file_exists($controllerOLD) && is_dir($viewFolderOLD)) {
			if(!rename($modelOLD, $modelNEW)) {
				$_SESSION['feedback_negative'][] = MVC_RENAME_ERROR.$modelOLD;
				return false;	
			}
			if(!rename($controllerOLD, $controllerNEW)) {
				$_SESSION['feedback_negative'][] = MVC_RENAME_ERROR.$controlelrOLD;
				return false;
			}
			if(!rename($viewFolderOLD, $viewFolderNEW)) {
				$_SESSION['feedback_negative'][] = MVC_RENAME_ERROR.$viewFolderOLD;
				return false;
			}
			if($files == true) {
				// Not yet
			}
			return true;
		} else {
			$_SESSION['feedback_negative'][] = MVC_DEFAULT_ERROR;
			return false;
		}*/
	}
}
?>