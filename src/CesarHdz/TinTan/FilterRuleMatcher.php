<?php

namespace CesarHdz\TinTan;

class FilterRuleMatcher
{

	private $definitions;

	public function __construct(){
		$this->setDefaultDefinitions();
	}


    public function getDefinition($name)
    {
        return $this->definitions[$name];
    }


    protected function setDefaultDefinitions(){
    	// Set definitions for number and string
    	$this->definitions = [];

    	$this->definitions['alphanumeric'] = '([a-zA-Z0-9-_]+)';
    	$this->definitions['alphabetic'] = '([a-zA-Z-_]+)';
    	$this->definitions['numeric'] = '(\d+)';
    }
}
