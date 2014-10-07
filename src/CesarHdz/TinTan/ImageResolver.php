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

    public function resolve($relativePath)
    {
        return new ImageInfo($this->dir, $relativePath);
    }
}
