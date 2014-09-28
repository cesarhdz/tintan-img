<?php

namespace CesarHdz\TinTan;

class ImageResolver
{

    private $dir;
    private $presets;

    public function __construct($dir = null){
        $this->setDir($dir ?: getcwd());
        $this->presets = [];
    }

    public function setDir($dir){
        $this->dir = rtrim($dir, '/') . '/';
    }

    public function getDir()
    {
        return $this->dir;
    }

    public function addPreset($name, $filter, array $args = []){
        $this->presets[] = new Preset($name, $filter, $args);
    }

    public function getPresets(){
        return $this->presets;
    }

    public function resolve($uri)
    {
        $matches = [];

        // Iterate overs presets to find the image path
        foreach ($this->presets as $preset){
            if($preset->match($uri)){
                $uri = $preset->removeFrom($uri);
                $matches[] = $preset;
            }
        }

        return new ImageInfo($this->dir, $uri, $matches);
    }

}
