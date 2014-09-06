<?php

namespace CesarHdz\TinTan;

class Preset
{

    const PREFIX = '.';

	protected $name;
    protected $filterName;
    protected $arguments;


	public function __construct($name, $filterName, array $arguments = array()){
		$this->name = $name;
        $this->filterName = $filterName;
        $this->arguments = $arguments;
	}

    public function getFilterName(){
        return $this->filterName;
    }


    public function match($img){
        $needle = self::PREFIX . $this->name;

        return (strpos($img, $needle) !== false) ? true : false;
    }


    public function removeFrom($uri){

        $search = self::PREFIX . $this->name;

        return str_replace($search, '', $uri);
    }

    public function getName()
    {
        return $this->name;
    }
}
