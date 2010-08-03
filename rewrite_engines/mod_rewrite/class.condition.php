<?php

require_once(dirname(__FILE__) . '/../interface.rewrite_condition.php');

class rewrite_condition_mod_rewrite implements rewrite_comment{

	private $_flags = Array();
	private $_matched_string = '';
	private $_condition = '';

	public function __construct($matched_string, $condition, $flags = null){
		$this->_matched_string = (string)$matched_string;
		$this->_condition = (string)$condition;
		if(empty($flags)){
			$flags = Array();
		}
		
		if(!is_array($flags)){
			$flags = Array($flags);
		}
		
		$this->_flags = $flags;
	}
	
	public function __toString(){
		$flags = (!empty($this->_flags))?' ['.@implode($this->_flags, ',').']':'';
		return $this->_matched_string . ' ' . $this->_condition . $flags;
	}
}