<?php
class overviewModel {
	private $db;
	private $statsDays = 7; // Statistics days
	
	public function __construct(Database $db) {
		$this->db = $db;		
	}
	
	public function newMsgs() {
		$this->db->where("contact_read", FALSE);
		$res = $this->db->get('contact');
		return count($res);	
	}
	
	public function userStatistics() {
		$relTime = time()-($this->statsDays*24*60*60);
		$this->db->where('visitor_time', $relTime, ">=");
		$res = $this->db->get('visitors');
		if(count($res)>0) {
			$chart = new chart('visitor_stats', 'Date', 'Visitors', 'Area', 250, false, "Visitors");
			$data = array();
			foreach($res as $r) {
				$date = date('Y-m-d', $r['visitor_time']);
				if(array_key_exists($date, $data)) {
					$data[$date]++;	
				} else {
					$data[$date] = 1;
				}
			}
			
			// We have to manually add "0":
			$u = 0;
			while($u<$this->statsDays) {
				$t = time()-$u*24*60*60;
				$key = date('Y-m-d', $t);
				if(!array_key_exists($key, $data)) {
					$data[$key] = 0;
				}
				$u++;	
			}
			
			foreach($data as $x => $y) {
				$chart->addData($x, $y);
			}
			return $chart->write();	
		} else {
			echo '<div class="jumbotron">No visitors in the past '.$this->statsDays.' days :-(</div>';
		}
	}
}
?>