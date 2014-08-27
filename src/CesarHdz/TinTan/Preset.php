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


    public function match($img){
        $needle = self::PREFIX . $this->name;

        return (strpos($img, $needle) !== false) ? true : false;
    }


    public function removeFrom($uri){

        $search = self::PREFIX . $this->name;

        return str_replace($search, '', $uri);
    }
}
