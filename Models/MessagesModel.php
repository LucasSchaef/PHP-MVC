<?php

class MessagesModel {
	private $db;
	
	
	public function __construct(Database $db) {
		$this->db = $db;
	}
	
	public function getMsgs($user_id) {
		$this->db->where('message_to', $user_id);
		$this->db->orWhere('message_from', $user_id);
		$this->db->orderby('message_sent', 'DESC');
		$msgs = $this->db->get('messages');
		foreach($msgs as $key => $msg) {
			if($msg['message_to'] == $user_id) {
				$this->db->where('user_ID', $msg['message_from']);
			} else {
				$this->db->where('user_ID', $msg['message_to']);
			}
			$other = $this->db->getOne('users', array('user_name', 'user_ID'));
			$conversation[$other['user_ID']][] = $msg;
			$conversation[$other['user_ID']]['other_user'] = $other['user_name'];
		}
		return $conversation;
	}
	
	public function getConv($me_id, $other_name) {
		// Get User's name
		$this->db->where('user_ID', $me_id);
		$me = $this->db->getOne('users', array('user_ID', 'user_name'));
		
		// Get other User's ID
		$this->db->where('user_name', $other_name);
		$other = $this->db->getOne('users', array('user_ID', 'user_name'));
		
		if(is_array($me) && is_array($other) && !isArrayEmpty($me) && !isArrayEmpty($other)) {
			// Get all messages
			$this->db->where('message_from = ? AND message_to = ?', array($me_id, $other['user_ID']));
			$this->db->orWhere('message_to = ? AND message_from = ?', array($me_id, $other['user_ID']));
			$this->db->orderby('message_sent', 'ASC');
			$conv = $this->db->get('messages');
			
			// Echo messages
			if(!isArrayEmpty($conv)) {
				$this->markRead($me['user_ID'], $other['user_ID']);
				$ret = '';
				foreach($conv as $msg) {
					if($msg['message_from'] == $me['user_ID']) {
						$sender = $me['user_name'];
					} else {
						$sender = '<a href="'.URL.'Profile/'.$other['user_name'].'">'.$other['user_name'].'</a>';
					}
					
					if($this->isToday($msg['message_sent'])) {
						$date_format = "h:i A";
					} else {
						$date_format = "l, d.m.Y h:i A";
					}
					
					$ret .= '<div class="message">
								<span class="pull-left msg_user">'.$sender.'</span>
								<span class="pull-right msg_time">'.date($date_format, $msg['message_sent']).'</span><br />
								<span class="msg-text">'.$msg['message_text'].'</span>
							</div>
							<hr />';
				}
				
				return $ret;
			}
		}
		return '<div class="row">
					<div class="col-md-12 text-center">
						<p class="bg-danger text-danger" style="padding:10px;">
							'.COULD_NOT_LOAD_MSG_ERROR.'
						</p>
					</div>
				</div>';
	}
	
	public function markRead($to, $from) {
		$this->db->where('message_from', $from);
		$this->db->where('message_to', $to);
		$this->db->update('messages', array('message_read'=>true));	
	}
	
	public function getUsers($input, $myname) {
		$this->db->where('UPPER(user_name)', '%'.strtoupper($input).'%', 'LIKE');
		$this->db->where('user_name', $myname, '<>');
		$possible = $this->db->get('users', 5);
		$ret = "";
		if(is_array($possible) && !isArrayEmpty($possible)) {
			foreach($possible as $user) {
				$user['user_name'] = preg_replace('/('.$input.')/i', '<span class="sug-match">$1</span>', $user['user_name']);
				$ret .= '<li>'.$user['user_name'].'</li>';	
			}
			return $ret;
		}
		return '<li>No matches</li>';
	}
	
	public function sendMsg($from, $to, $msg, $ret = false) {
		if(!is_int($from)) {
			$from_name = $from;
			$this->db->where('user_name', $from);
			$from = $this->db->getOne('users', NULL, array('user_ID'))['user_ID'];
		} else {
			$this->db->where('user_ID', $from);
			$from_name = $this->db->getOne('users', NULL, array('user_name'))['user_name'];
		}
		
		if(!is_int($to)) {
			$to_name = $to;
			$this->db->where('user_name', $to);
			$to = $this->db->getOne('users', NULL, array('user_ID'))['user_ID'];
		} else {
			$this->db->where('user_ID', $to);
			$to_name = $this->db->getOne('users', NULL, array('user_name'))['user_name'];
		}
		
		$time = time();
		
		$insert = array('message_from'=>$from,
						'message_to'=>$to,
						'message_text'=>$msg,
						'message_sent'=>$time,
						'message_read'=>false);
		$this->db->insert('messages', $insert);
		
		if($ret) {
			return '<div class="message" id="reply" style="display:none">
						<span class="pull-left msg_user">'.$from_name.'</span>
						<span class="pull-right msg_time">'.date("h:i A", $time).'</span><br />
						<span class="msg-text">'.$msg.'</span>
					</div>
					<hr />';	
		}
		return true;
			
	}
	
	private function isToday($time) {
		if(date("d.m.Y", $time) == date("d.m.Y", time())) {
			return true;
		}
		return false;
	}
}

?>