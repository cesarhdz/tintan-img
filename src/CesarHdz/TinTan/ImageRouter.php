<?php

namespace CesarHdz\TinTan;

class ImageRouter
{

	const RULE_DELIMITER = '.';

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

    /**
     * Matches an uri against a set of rules
     * and populate dynamic params
     * 
     * @param  String 				$uri 	Requested URI
     * @param  Array<FilterRule> 	$rules 	Rules
     * @return Array<FilterRule>            Matches rules sorted
     */
    public function matchRules($uri, array $rules = [])
    {
    	$info = $this->getUriInfo($uri);


    	// Collect patterns
    	$matched = array_map(function($pattern) use ($rules){
    		
    		// Iterate over matches
    		foreach ($rules as $rule){
    			preg_match_all(
    				'/'.$rule->getPattern().'/', 
    				$pattern,
    				$matches
    			);

    			if($matches[0]){
	    			// We have a match
	    			return $rule;
    			}
    		}



    	}, $info['patterns']);


    	return $matched;
    }


    protected function getUriInfo($uri){
    	// Get final path
    	$info = new \SplFileInfo($uri);

    	// Get name and paths
    	$fullName = $info->getBasename('.'.$info->getExtension());
    	$parts = explode(self::RULE_DELIMITER, $fullName);

    	return [
    		'baseName' => array_shift($parts) . '.' . $info->getExtension(),
    		'patterns' => $parts,
    		'path'	   => $info->getPath()	
    	];
    }
}
