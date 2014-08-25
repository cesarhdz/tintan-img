<?php

namespace CesarHdz\TinTan;

use Symfony\Component\Finder\Finder;

class ImageLocator
{

	protected $dirs;

	public function __construct(){
		$this->dirs = array();
	}

    public function addDir($dir)
    {
        $this->dirs[] = $dir;
    }

    public function exists($path)
    {
        $files = $this->queryFor($path);

        return count($files) ? true : false;
    }

    public function get($path)
    {
        $files = $this->queryFor($path);

        foreach ($files as $img) {
        	return $img;
        }
    }

    protected function queryFor($path){
    	$finder = $this->getFinder();
    	

    	$finder->files()->path($path);

    	foreach ($this->dirs as $dir) {
    		$finder->in($dir);
    	}

    	return $finder;
    }

    protected function getFinder(){
    	return new Finder();
    }
}
