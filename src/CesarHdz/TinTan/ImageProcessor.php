<?php

namespace CesarHdz\TinTan;

use Intervention\Image\ImageManager;

class ImageProcessor
{

	protected $presets;
    protected $manager;


	public function __construct($dir = null){
		$presets = array();

        $this->setDir($dir ?: getcwd());
	}

    public function setDir($dir){
        $this->dir = rtrim($dir, '/') . '/';
    }

    public function setPresets(array $presets)
    {
    	foreach ($presets as $name => $params) {

    		if(!array_key_exists('filter', $params))
    			throw new \Exception('Preset requires a filter name to bevalid');


			$args = array_key_exists('args', $params) ? $params['args'] : [];

			$this->presets[] = new Preset($name, $params['filter'], $args);
    	}
    }

    public function buildImageInfo($uri)
    {
    	$matched = [];

        if($this->hasPresets()){
            foreach ($this->presets as $preset){
            	if($preset->match($uri)){
            		$uri = $preset->removeFrom($uri);
            		$matched[] = $preset;
            	}
            }
        }


        $file = new ImageInfo($this->dir . $uri, $matched);

        // If we have a proper imagen, then it is added to Image Info
        if($file->isImage()){
            $path = $file->getRealPath();
            $file->setImage($this->manager->make($path));
        }

        return $file;
    }

    public function process(ImageInfo $img, Application $app)
    {
        array_map(function($preset) use($app, $img){
            $filter = $app[$preset->getFilterName()];
            $filter->filter($img, $preset, $app);
        }, $img->getPresets());

        return $img;
    }

    public function hasPresets(){
        return is_array($this->presets) && count($this->presets);
    }

    public function setManager(ImageManager $manager)
    {
        $this->manager = $manager;
    }
}
