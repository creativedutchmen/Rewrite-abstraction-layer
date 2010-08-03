<?php

interface rewrite_engine{

	public function __construct();
	
	//the identifier is used to edit some parts of a rewrite file, or to delete parts.
	public function addRuleset($identifier);
	
	public function getRuleset($identifier);
	
	public function parseFromFile($filename);
	
	public function __toString();
}