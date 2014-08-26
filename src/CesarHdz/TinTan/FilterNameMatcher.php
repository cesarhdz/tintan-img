<?php

namespace CesarHdz\TinTan;

class FilterNameMatcher
{

	protected $pattern;


	/**
	 * Set default pattern
	 * @param String $pattern
	 * @return  void
	 */	
    public function setPattern($pattern)
    {	
    	$pattern = preg_quote($pattern, '#');

    	// convert back ? sign
    	$pattern = str_replace('\\?', '?', $pattern);

    	// convert %d into (\d+)
    	$pattern = str_replace('%d', '(\d+)', $pattern);

    	// convert %s into ([a-z]+)
    	$pattern = str_replace('%s', '([a-zA-Z]+)', $pattern);

    	$pattern = str_replace('\*', '.*', $pattern);
    	
    	// Set Pattern
        $this->pattern = '#'.$pattern.'#i';
    }

    public function match($search)
    {
    	$match = preg_match($this->pattern, $search, $params);
    	
    	$this->params = (count($params)) 
    				 ? array_shift($params) : [];

        return $match == 1 ? true : false;
    }
}
