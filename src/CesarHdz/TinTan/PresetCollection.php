<?php

namespace CesarHdz\TinTan;

class PresetCollection implements \ArrayAccess, \Countable
{

	private $presets;

	public function __construct(array $presets = []){
		$this->presets = $presets;
	}

    public function findAllByUri($uri)
    {
        $matched = [];

        foreach ($this->presets as $preset){
        	if($preset->match($uri)){
        		$uri = $preset->removeFrom($uri);
        		$matched[] = $preset;
        	}
        }

        return new PresetCollection($matched);
    }

    public function count()
    {
        return count($this->presets);
    }

    public function get()
    {
        return $this->presets;
    }

    public function add($name, FilterInterface $filter)
    {
        $this->presets[] = new Preset($name, $filter);
    }

    public function offsetGet($name){
    	foreach ($this->presets as $preset){
    		if($preset->getName() == $name){
    			return $preset;
    		}
    	}
    }

    public function offsetSet($name, $value){
    	throw new Exception('Offset Set not Available');
    }

    public function offsetUnset($name){
    	throw new Exception('Offset unset not available');
    }

    public function offsetExists($name){

    }

}
