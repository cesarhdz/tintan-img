<?php

namespace CesarHdz\TinTan;

class FilterRule
{

	private $pattern;
	private $filterName;
	private $params;

    public function __construct($pattern, $filterName, array $params = [])
    {
        $this->pattern = $pattern;
        $this->filterName = $filterName;
        $this->params = $params;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getFilterName()
    {
        return $this->filterName;
    }

    public function getParams()
    {
        return $this->params;
    }
}
