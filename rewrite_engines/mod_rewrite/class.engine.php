<?php

require_once(dirname(__FILE__) . '/../interface.rewrite_engine.php');
require_once(dirname(__FILE__) . '/class.rule.php');
require_once(dirname(__FILE__) . '/class.comment.php');
require_once(dirname(__FILE__) . '/class.condition.php');
require_once(dirname(__FILE__) . '/class.ruleset.php');

class rewrite_engine_mod_rewrite implements rewrite_engine{
	
	private $_rulesets = Array();
	
	public function __construct($file = null){
		if(!empty($file)){
			return $this->parseFromFile($file);
		}
	}
	
	//it is not encouraged to have the identifier as null.
	//only, to be able to import older htaccess files, and files that are edited outside this method, it is an option.
	
	//$position can have the following values:
	//'bottom', 'top', Array('before'=>ruleset_intentifier), Array('after'=>ruleset_identifier)
	public function addRuleset($identifier = null, $position = 'bottom'){
		$ruleset = new rewrite_ruleset_mod_rewrite($identifier);
		
		$id = ($identifier != null)?$identifier:count($this->_rulesets);
		
		if(is_array($position)){
			
			if(!empty($position['before'])){
				if(array_key_exists($position['before'], $this->_rulesets)){
					$keys = array_keys($this->_rulesets);
					$key = array_search($position['before'], $keys);
					if($key === FALSE){
						throw new Exception('The ruleset to place the rules before can not be found');
					}
				}
			}
			elseif(!empty($position['after'])){
				if(array_key_exists($position['after'], $this->_rulesets)){
					$keys = array_keys($this->_rulesets);
					$key = array_search($position['after'], $keys) + 1;
					if($key === FALSE){
						throw new Exception('The ruleset to place the rules after can not be found');
					}
				}
			}
		}		
		elseif($position == 'top'){
			$key = 0;
		}
		//default: bottom;
		else{
			$key = count($this->_rulesets);
		}
		
		$tmp_arr = array_splice($this->_rulesets, $key);
		$this->_rulesets = array_merge($this->_rulesets, Array($id => $ruleset));
		$this->_rulesets = array_merge($this->_rulesets, $tmp_arr);
		
		return $ruleset;
	}
	
	public function getRuleset($identifier){
		return (!empty($this->_rulesets[$identifier]))?$this->_rulesets[$identifier]:false;
	}
	
	public function parseFromFile($filename){
	}
	
	public function __toString(){
		$string = '';
		foreach($this->_rulesets as $ruleset){
			$string .= $ruleset . "\r\n";
		}
		return $string;
	}
}