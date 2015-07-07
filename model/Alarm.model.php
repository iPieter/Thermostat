<?php

class Alarm
{
	private $_alarm_id;
	private $_spark_id;
	private $_spark_token;
	private $_location_name;

	function __construct($alarm_id, $spark_id, $spark_token, $location_name) {
			
		$this->_alarm_id = $alarm_id;
		$this->_spark_id = $spark_id;
		$this->_spark_token = $spark_token;
		$this->_location_name = $location_name;
	}
	
	function getHTML() {
	}
	
}
