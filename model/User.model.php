<?php
class User 
{
	private $_id;
	private $_name;
	private $_model;
	
	function __construct($username, $model) {
		$userrow = mysqli_fetch_array($model->query("SELECT * FROM users WHERE username = '$username'"));
		
		$this->_id=$userrow['id'];
		$this->_name=$userrow['username'];
		$this->_model = $model;
		
	}
	
	function getId() {
		return $this->_id;
	}
	
	function getName() {
		return $this->_name;
	}
	
	function getDevices($func) {
		$devices = $this->_model->query("SELECT * FROM devices WHERE function = '$func' ");
		return $devices;
	}
	
	function hasAccess($func) {
		$devices = $this->_model->query("SELECT * FROM user_access WHERE user_id =" .$this->_id . " AND enabled=1 AND module = '$func'");

		if ($devices->num_rows > 0 ) {
			return true;
		} else {
			return false;
		}
	}
}