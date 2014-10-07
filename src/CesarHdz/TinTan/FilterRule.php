<?php

namespace CesarHdz\TinTan;

class FilterRule
{

	private $pattern;
	private $filterName;
	private $params;

    private $regex;
    private $args;

    public function __construct($pattern, $filterName, array $params = [])
    {
        $this->pattern = $pattern;
        $this->filterName = $filterName;
        $this->params = $params;

        $this->args = [];
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getFilterName()
    {
        return $this->filterName;
    }

    public function addParam($key, $val){
        $this->params[$key] = $val;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setRegex($regex){
        $this->regex = $regex;
    }

    public function setArguments(array $args){
        $this->args = $args;
    }

    public function getArguments()
    {
        return $this->args;
    }

    public function getRegex()
    {
        return $this->regex;
    }
}
