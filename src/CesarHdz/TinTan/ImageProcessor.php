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

    public function addPreset($name, FilterInterface $filter, array $config = []){
		$this->presets[] = new Preset($name, $filter, $config);
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

        //@TODO Save matched requests somewhere else
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
        $presets = $img->getPresets();


        foreach ($presets as $preset) {
            $img = $preset->getFilter()->filter($img, $preset, $app);
        }

        return $img;
    }

    public function hasPresets(){
        return is_array($this->presets) && count($this->presets);
    }
}
