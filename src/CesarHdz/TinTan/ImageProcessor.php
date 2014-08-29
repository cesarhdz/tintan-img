<?php

namespace CesarHdz\TinTan;

class ImageProcessor
{

	protected $presets;


	public function __construct(){
		$presets = array();
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

    public function buildImage($uri)
    {
    	$matched = [];

        foreach ($this->presets as $preset){
        	if($preset->match($uri)){
        		$uri = $preset->removeFrom($uri);
        		$matched[] = $preset;
        	}
        }

        return new Image($uri, $matched);
    }

    public function process(Image $img, Application $app)
    {
        array_map(function($preset) use($app, $img){
            $filter = $app[$preset->getFilterName()];
            $filter->filter($img, $preset, $app);
        }, $img->getPresets());

        return $img;
    }
}
