<?php

namespace CesarHdz\TinTan;

class Preset
{

    const PREFIX = '.';

	protected $name;
    protected $filter;
    protected $arguments;


	public function __construct($name, $filter, array $arguments = array()){
		$this->name = $name;
        $this->filter = $filter;
        $this->arguments = $arguments;
	}

    public function getFilter(){
        return $this->filter;
    }


    public function match($uri){
        $needle = self::PREFIX . $this->name;

        return (strpos($uri, $needle) !== false) ? true : false;
    }


    public function removeFrom($uri){

        $search = self::PREFIX . $this->name;

        return str_replace($search, '', $uri);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getArguments(){
        return $this->arguments;
    }
}
