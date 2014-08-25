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
        $finder = $this->getFinder();
        $finder->path($path);

        return count($finder) ? true : false;
    }


    protected function getFinder(){
    	$finder = new Finder();
    	$finder->files();

    	foreach ($this->dirs as $dir) {
    		$finder->in($dir);
    	}

    	return $finder;
    }
}
