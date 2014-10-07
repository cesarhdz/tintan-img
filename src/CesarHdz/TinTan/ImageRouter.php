<?php

namespace CesarHdz\TinTan;

class ImageRouter
{

	const RULE_DELIMITER = '.';

	private $definitions;
    private $rules;

	public function __construct(){
		$this->setDefaultDefinitions();
        $this->rules = [];
	}

    public function getDefinition($name)
    {
        return $this->definitions[$name];
    }


    protected function setDefaultDefinitions()
    {
    	// Set definitions for number and string
    	$this->definitions = [];

    	$this->definitions['alpha'] = '([a-zA-Z-_]+)';
    	$this->definitions['alphanum'] = '([a-zA-Z0-9-_]+)';
    	$this->definitions['num'] = '(\d+)';
    }


    public function addRule($pattern, $filter, array $arguments = [])
    {
        $this->rules[] = new FilterRule($pattern, $filter, $arguments);
    }

    public function getRules()
    {
        return $this->rules;
    }


    public function buildRules()
    {
        $this->rules = array_map([$this, 'buildRule'], $this->rules);
    }

    protected function buildRule(FilterRule $rule){
        $pattern = $rule->getPattern();

        // extract wildcards
        preg_match_all('/{(.*?)}/', $rule->getPattern(), $matches);

        // Second item contains only wildcards
        $matches = $matches[1];
        $args = [];

        // Get arguments
        foreach($matches as $match){
            $parts = explode(':', $match);
            $args[] = $parts[0];

            $definition = $this->getDefinition($parts[1]);

            // Replace patter with definition
            $pattern = str_replace('{'.$match.'}', $definition, $pattern);
        }

        $rule->setRegex('#'.$pattern.'#');
        $rule->setArguments($args);

        return $rule;
    }


    public function getRouteFor($uri){
        // Get final path
        $info = new \SplFileInfo($uri);

        // Get name and paths
        $fullName = $info->getBasename('.'.$info->getExtension());
        $parts = explode(self::RULE_DELIMITER, $fullName);

        $path =   $info->getPath() . '/' . array_shift($parts) . '.' . $info->getExtension();

        return new Route($uri, $path, $parts);
    }

    /**
     * Matches a Route against a registerd routes
     * and populate dynamic params
     * 
     * @param  String               $uri    Requested URI
     * @return Array<FilterRule>            Matches rules sorted
     */
    public function getRulesForRoute(Route $route)
    {
        // Collect patterns
        $matched = array_map(function($pattern){
            
            return $this->match($pattern);

        }, $route->getPatterns());

        return $matched;
    }



    protected function match($pattern){
        // Iterate over matches
        foreach ($this->rules as $rule){
            preg_match_all(
                $rule->getRegex(),
                $pattern,
                $matches
            );

            // Only when we have a match, we return a rule
            if($matches[0]){
                // Add dynamic param values
                foreach ($rule->getArguments() as $i => $arg){
                    $rule->addParam($arg, $matches[$i + 1][0]);
                }

                return $rule;
            }
        }
    }
}
