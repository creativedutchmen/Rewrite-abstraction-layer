<?php

require_once(dirname(__FILE__) . '/../interface.rewrite_comment.php');

class rewrite_comment_mod_rewrite implements rewrite_comment{
	
	private $_content  = '';
	
	public function __construct($content){
		$this->setContent($content);
	}
	
	public function setContent($content){
		$this->_content = (string)$content;
	}
	
	public function getContent(){
		return $this->_content;
	}
	
	public function __toString(){
		return '# ' . $this->_content;
	}	
}