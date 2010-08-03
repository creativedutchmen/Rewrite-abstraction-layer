<?php

require_once(dirname(__FILE__) . '/../interface.rewrite_ruleset.php');

class rewrite_ruleset_mod_rewrite implements rewrite_ruleset{
	
	private $_elements = Array();
	private $_identifier = '';
	
	public function __construct($identifier = null){
		$this->_identifier = ($identifier != null)?$identifier:'please_set_id';
		$this->addComment('@id: ' . $this->_identifier);
	}
	
	public function addComment($content){
		$comment = new rewrite_comment_mod_rewrite($content);
		$this->addObject($comment);
	}
	
	public function addCondition($matched_string, $condition, $flags = null){
		$condition = new rewrite_condition_mod_rewrite($matched_string, $condition, $flags);
		$this->addObject($condition);
	}
	
	public function addRule($args){
	}
	
	private function addObject($object){
		//TODO: implement check to see if the object is a supported one
		$this->_elements[] = $object;
	}
	
	public function __toString(){
		$string = '';
		
		foreach($this->_elements as $element){
			$string .= $element . "\r\n";
		}
		return $string;
	}
}