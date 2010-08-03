<?php

interface rewrite_ruleset{
	
	public function __construct($identifier);
	
	public function addComment($content);
	
	public function addCondition($matched_string, $condition, $flags = null);
	
	public function addRule($content);
}