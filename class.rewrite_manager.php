<?php

class engine_iterator extends FilterIterator{
	
	private $rewrite_engines_path = 'rewrite_engines';
	
	public function __construct(){
		parent::__construct(new DirectoryIterator($this->rewrite_engines_path));
	}
	
	public function accept(){
		$file = $this->getInnerIterator()->current();
		if($file->isDir()){
			if(file_exists($file->getPathname() . '/class.engine.php')){
				return true;
			}			
		}
	}
	
}

class rewrite_manager{

	static $_engine;
	
	public function __construct($engine = 'mod_rewrite'){
		foreach(new engine_iterator as $rewrite_engine){
			if($rewrite_engine == $engine){
				require_once($rewrite_engine->getPathname() . '/class.engine.php');
				$className = 'rewrite_engine_' . $rewrite_engine->getBasename();
				if(class_exists($className)){
					$this->_engine = new $className;
					if(!is_a($this->_engine,'rewrite_engine')){
						throw new Exception('Every engine should implement the rewrite_array interface provided in the rewrite_engines folder');
					}
				}
				else{
					throw new Exception('No classname "'.$className.'" defined. Please check the mod_rewrite class for an example of how to build new engines');
				}
			}
		}
		if(empty($this->_engine)){
			throw new Exception('The engine: "'.$engine.'" has not been installed yet. Please read the readme on how to install new rewrite engines');
		}
	}
	
	public function getEngine(){
		return $this->_engine;
	}
	
	public function saveToFile($engine, $path){
	}
}

$rewrite_manager = new rewrite_manager();
$ruleset = $rewrite_manager->getEngine()->addRuleset('test2', 'bottom');
$ruleset2 = $rewrite_manager->getEngine()->addRuleset('test', Array('before'=>'test2'));

$ruleset2->addComment('boo!');
$ruleset2->addCondition('text','test','OR');
$ruleset->addCondition('text','test','OR');

echo $rewrite_manager->getEngine();