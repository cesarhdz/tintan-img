<?php

namespace CesarHdz\TinTan;

class ImageResolver
{

    private $dir;

    public function __construct($dir = null){
        $this->setDir($dir ?: getcwd());
    }

    public function setDir($dir){
        $this->dir = rtrim($dir, '/') . '/';
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function resolve($uri, array $presets)
    {
        // Iterate overs presets to find the image path
        foreach ($presets as $preset){
            if($preset->match($uri)){
                $uri = $preset->removeFrom($uri);
                $matched[] = $preset;
            }
        }

        return new ImageInfo($this->dir, $uri, $presets);
    }

}
