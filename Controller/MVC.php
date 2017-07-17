<?php
class MVC extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$model = $this->loadModel("MVC");
		$this->view->MVCList = $model->listMVCs();
		$this->view->render('MVC/index');
	}
	
	public function delete($params) {
		$model = $this->loadModel("MVC");
		if(count($params)<2) {
			$name = $model->getMVCbyID($params[0]);
			$this->view->delName = $name;
			$this->view->render('MVC/Confirm');	
		} else {
			$model = $this->loadModel("MVC");
			if($model->delete($params[0])) {
				$_SESSION['feedback_positive'][] = "MVC successfully deleted.";
			}
				header("Location: ".URL."MVC");
		}
			
	}
	
	public function edit($params) {
		$this->db->where('mvc_name', $params[0]);
		$res = $this->db->getOne('mvcs');
		if($this->db->count > 0) {
			$this->view->mvc = $res;
			$this->view->render('mvc/edit');
		} else {
			header('Location: '.URL.getCurrentController());
		}
	}
	
	public function create() {
		if(!isset($_POST['mvc_name']) OR empty($_POST['mvc_name'])) {
			$this->view->render('MVC/Create');
		} else {
			$model = $this->loadModel("MVC");
			if($model->create($_POST['mvc_name'])) {
				header("Location: ".URL.getCurrentController());
			} else {
				$this->view->render('MVC/create');
			}
		}
	}
	
	public function getEditContent() {
		if(!empty($_REQUEST['file'])) {
			switch($_REQUEST['file']) {
				case 'Overview':
					echo 'Overview';
				break;
				case 'add_view':
					echo '<div class="form-group">';
					echo '<label for="add_view_name">Name</label>';
					echo '<input type="text" id="add_view_name" class="form-control" placeholder="Name..." />';
					echo '</div>';
					echo '<div class="form-group">';
					echo '<label for="add_view_content">Content</label>';
					echo '<textarea id="add_view_content" name="add_view_content" rows="8" class="form-control">';
					echo htmlspecialchars("<div class=\"container-fluid\">\n\t<div class=\"panel panel-default\">\n\t\t<div class=\"panel-heading\">About-Us</div>\n\t\t<div class=\"panel-body\">\n\t\t\tHello World!\n\t\t</div>\n\t</div>\n</div>");
					echo '</textarea>';
					echo '</div>';
					echo '<button type="submit" class="btn btn-default">Save</button>';
				break;
				default:
					if(file_exists($_REQUEST['file']) && is_readable($_REQUEST['file'])) {
						$file = fopen($_REQUEST['file'], 'r');
						$content = "";
						$rows = 0;
						while($buffer = htmlspecialchars(fgets($file, 4069))) {
							$content .= $buffer;
							$rows++;
						}
						echo '<div class="form-group">';
						echo '<label for="edit_file_content">Edit '.$_REQUEST['file'].'</label>';
						echo '<textarea rows="'.$rows.'" id="edit_file_content" name="'.$_REQUEST['file'].'" class="form-control">';
						echo $content;
						echo '</textarea>';
						echo '</div>';
						echo '<button type="submit" class="btn btn-default">Save</button>';
					} else {
						goto mvc_error;
					}
				break;
			}
		} else {
			mvc_error:
			echo '<div class="form-group text-center"><p class="help-block">Please select a file from the left.</p></div>';
			return false;
		}
	}
	
	public function saveFileChanges() {
		if(isset($_REQUEST['file']) && !empty($_REQUEST['file']) && isset($_REQUEST['file_content']) && !empty($_REQUEST['file_content'])) {
			if(file_exists($_REQUEST['file']) && is_writeable($_REQUEST['file'])) {
				$file = fopen($_REQUEST['file'], 'w+');
				if(!fwrite($file, $_REQUEST['file_content'])) {
					goto save_error;
				} else {
					echo "Saved";
				}
			} else {
				goto save_error;
			}
		} else {
			save_error:
			header('HTTP/1.1 500 Internal Server Booboo');
        	header('Content-Type: application/json; charset=UTF-8');
        	die();
		}
	}
}
?>