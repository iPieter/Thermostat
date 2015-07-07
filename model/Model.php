<?php 
class Model 
{
	private $_datasource;
	
	function __construct() {
		$this->_datasource = new mysqli("127.0.0.1", "thermostat", "6VSKjyAw5vUTTdHG", "thermostat");
	}
	
	function close() {
		$this->_datasource->close();
	}
	
	function query($q) {
		return $this->_datasource->query($q);
	}
	
}