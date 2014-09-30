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

    	$this->definitions['alpha'] = '([a-zA-Z-_]+)';
    	$this->definitions['alphanum'] = '([a-zA-Z0-9-_]+)';
    	$this->definitions['num'] = '(\d+)';
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

    	$rules = array_map([$this, 'buildPattern'], $rules);

    	// Collect patterns
    	$matched = array_map(function($pattern) use ($rules){
    		
    		return $this->match($pattern, $rules);

    	}, $info['patterns']);

    	var_dump($matched);


    	return $matched;
    }


    protected function buildPattern(FilterRule $rule){

    	$pattern = $rule->getPattern();

    	// extract wildcards
    	preg_match_all('/{(.*?)}/', $rule->getPattern(), $matches);

    	// Second item contains only wildcards
    	$matches = $matches[1];
    	$args = [];

    	foreach($matches as $match){
    		$parts = explode(':', $match);
    		$args[] = $parts[0];

    		$definition = $this->getDefinition($parts[1]);

    		// Replace patter with definition
    		$pattern = str_replace('{'.$match.'}', $definition, $pattern);
    	}

    	return [
    		'pattern' => '#'.$pattern.'#',
    		'args' => $args,
    		'rule' => $rule
    	];
    }


    protected function match($pattern, array $rules){
		// Iterate over matches
		foreach ($rules as $rule){
			preg_match_all(
				$rule['pattern'],
				$pattern,
				$matches
			);

			if($matches[0]){
    			// We have a match
    			$rule['matches'] = $matches;
    				
    			$rule['params'] = array();

    			foreach ($rule['args'] as $i => $arg){
    				$rule['params'][$arg] = $matches[$i + 1][0];
    			}

    			return $rule;
			}
		}
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
