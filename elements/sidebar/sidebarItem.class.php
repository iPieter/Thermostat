<?php
class SideBarItem
{
	private $_name;
	private $_icon;
	private $_url;
	
	function __construct($name, $icon, $url) {
		$this->_name = $name;
		$this->_icon = $icon;
		$this->_url = $url;
	}
	
	function getHTML($base, $current) {
		if ($current == ($this->_url)) {
			return "<li class='active'><a href='" . $base . $this->_url . "' data-target='#'><span class='glyphicon glyphicon-". $this->_icon . "'></span> ". $this->_name ."</a></li>";
		} else {
			return "<li><a href='" . $base . $this->_url . "' data-target='#'><span class='glyphicon glyphicon-". $this->_icon . "'></span> ". $this->_name ."</a></li>";

		}
		
	}
}
