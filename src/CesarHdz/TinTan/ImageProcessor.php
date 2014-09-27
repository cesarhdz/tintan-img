<?php

namespace CesarHdz\TinTan;

use Intervention\Image\ImageManager;

class ImageProcessor
{

	protected $presets;
    private $manager;


	public function __construct(ImageManager $manager = null, $dir = null){
		$presets = array();

        $this->setDir($dir ?: getcwd());
        $this->manager = $manager ?: new ImageManager();
	}

    public function setDir($dir){
        $this->dir = rtrim($dir, '/') . '/';
    }

    public function addPreset($name, ImageFilter $filter, array $config){
		$this->presets[] = new Preset($name, $filter, $config);
    }

    //@deprecated
    public function setPresets(array $presets)
    {
        foreach ($presets as $name => $params) {
            // $this->addPreset($name, $params['filter'], $params);
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
}
