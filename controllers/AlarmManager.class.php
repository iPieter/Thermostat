<?php
class AlarmManager 
{
	private $_alarms;
	private $_user;
	
	function __construct($user) {
		//get the alarms from the model into the alarms array
		$this->_alarms = $user->getDevices('alarm');
		
		//save the user object
		$this->_user = $user;
	}
	
	function getAlarmNames() {
		//return a decription of all the alarms as a string array
		$names = array();
		
		foreach ($this->_alarms as $alarm) {
			$names[] = $alarm['id']; //TODO: a better name, the id for now
		}
		
		return $names;
	}
	
	function getAlarmArray() {
		//return a decription of all the alarms as a string array
		$alarmsArray = array();
		
		foreach ($this->_alarms as $alarm) {
			$alarmsArray[] = new Alarm($alarm['id'],$alarm['spark_id'],$alarm['spark_token'],$alarm['location_name']);
		}
		
		return $alarmsArray;
	}
	
}
