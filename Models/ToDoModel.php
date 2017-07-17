<?php

class ToDoModel {
	private $db;
	
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function loadTasks($user_ID) {
		$this->db->where('u.user_ID', $user_ID);
		$this->db->join('tasks t', 'u.task_ID = t.task_ID');
		return $this->db->get('users_tasks u');
	}
	
	public function loadTaskList($user_ID) {
		$tasks = $this->loadTasks($user_ID);
		$return = "";
		$stasks['overdue'] = 0;
		$stasks['late'] = 0;
		foreach($tasks as $task) {
			$overdue = false;
			$late = false;
			if($task['task_end'] < time() && $task['task_progress'] < 100) {
				$overdue = true;
				$stasks['overdue']++;	
			} elseif($task['task_end'] <= (time()+7*24*60*60) && $task['task_progress'] < 100) {
				$late = true;
				$stasks['late']++;
			}
			$progress = 'success';
			$return .= '<tr';
			
			if($overdue) {
				$return .= ' class="danger"';
				$progress = 'danger';
			} elseif($late) {
				$return .= ' class="warning"';	
				$progress = 'warning';
			} elseif($task['task_progress'] == 100) {
				$return .= ' class="success"';
			}
				
			$return .= ' id="'.$task['task_ID'].'">';
			$return .= '<td>'.$task['task_ID'].'</td>';
			$return .= '<td>';
			switch($task['task_importance']) {
				case 1:
					$return .= '<i class="fa fa-fw fa-exclamation"></i> High';
					break;
				case 2:
					$return .= '<i class="fa fa-fw fa-flag"></i> Medium';
					break;
				case 3:
					$return .= '<i class="fa fa-fw fa-flag-o"></i> Low';
					break;
			}
			$return .= '</td>';
			$return .= '<td>'.$task['task_name'].'</td>';
			$return .= '<td>'.date('d.m.Y', $task['task_start']).'</td>';
			$return .= '<td>'.date('d.m.Y', $task['task_end']).'</td>';
			$return .= '<td>';
			$return .= '<div class="progress" style="margin-bottom:0;"><div class="progress-bar progress-bar-'.$progress.'" role="progressbar" aria-valuenow="'.$task['task_progress'].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$task['task_progress'].'%"><span class="sr-only">'.$task['task_progress'].'% Complete (success)</span></div></div>';
			$return .= '</td>';
			$return .= '<td class="task_options">';
			if($task['task_progress'] < 100) {
				$return .= '<a data-toggle="tooltip" data-placement="bottom" href="#" class="task_add_10" id="'.$task['task_ID'].'" title="Add 10%"><i class="fa fa-plus"></i></a> ';
				$return .= '<a data-toggle="tooltip" data-placement="bottom" href="#" class="task_done" id="'.$task['task_ID'].'" title="Done"><i class="fa fa-check"></i></a> ';
			}
			$return .= '<a data-toggle="tooltip" data-placement="bottom" href="'.URL.getCurrentController().'/Edit/'.$task['task_ID'].'" title="Edit"><i class="fa fa-wrench"></i></a>';
			$return .= '</td>';
			$return .= '</tr>';
		}
		
		return array("tasks"=>$return)+$stasks;
	}
	
	public function loadSingleTask($task_ID, $user_ID) {
		$this->db->where('task_ID', $task_ID);
		$task = $this->db->getOne('tasks');
		if($this->db->count > 0) {
			$this->db->where('user_ID', $user_ID);
			$this->db->where('task_ID', $task_ID);
			$res = $this->db->get('users_tasks');
			if($this->db->count > 0) {
				return $task;
			}
		}
		return false;
	}
	
	public function setProgress($task_ID, $progress) {
		if(is_int($task_ID) && is_int($progress)) {
			if($progress < 0) {
				$progress = 0;
			} elseif($progress > 100) {
				$progress = 100;
			}
			
			$this->db->where('task_ID', $task_ID);
			if($this->db->update('tasks', array('task_progress'=>$progress))) {
				return true;
			}
		}
		return false;
	}
	
	public function setDone($task_ID) {
		return $this->setProgress($task_ID, 100);	
	}
	
	public function saveChanges($user_ID) {
		if(riane('task_ID', 'task_name', 'task_progress', 'task_short_desc', 'task_long_desc', 'task_start', 'task_end')) {
			$update = array(
						'task_name'=>$_REQUEST['task_name'],
						'task_progress'=>$_REQUEST['task_progress'],
						'task_short_desc'=>$_REQUEST['task_short_desc'],
						'task_long_desc'=>$_REQUEST['task_long_desc'],
						'task_start'=>strtotime($_REQUEST['task_start']),
						'task_end'=>strtotime($_REQUEST['task_end']));
			$this->db->where('task_ID', $_REQUEST['task_ID']);
			if($this->db->update('tasks', $update)) {
				return true;
			}
		}
		return false;
	}
	
}

?>