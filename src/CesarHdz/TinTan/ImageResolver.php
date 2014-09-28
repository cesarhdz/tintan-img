<?php

namespace CesarHdz\TinTan;

class ImageResolver
{

    public function resolve($uri, array $presets)
    {
    	// Iterate overs presets to find the image path
    	foreach ($presets as $preset){
           	if($preset->match($uri)){
        		$uri = $preset->removeFrom($uri);
        		$matched[] = $preset;
        	}
    	}

    	return new ImageInfo($uri, $presets);
    }
}
