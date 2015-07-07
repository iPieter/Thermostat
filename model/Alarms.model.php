<?php 

require_once("Model.php");

class Alarms extends Model {

	public function __construct() {
		parent::__construct();
	}	
	
	function getAlarms($userId) {
		$devices = mysqli_query($this->getDatasource(),"SELECT * FROM devices WHERE user_id = $userId && function='alarm'");
		return $devices;
		$this->close();
	}
	

	
}
