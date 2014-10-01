<?php

namespace CesarHdz\TinTan;

class Route{

    private $uri;
    private $basename;
    private $patterns;


    public function __construct($uri, $basename, array $patterns){
        $this->uri = $uri;
        $this->basename = $basename;
        $this->patterns = $patterns;
    }

    public function getUri(){
        return $this->uri;
    }

    public function getBasename(){
        return $this->basename;
    }

    public function getPatterns(){
        return $this->patterns;
    }

}