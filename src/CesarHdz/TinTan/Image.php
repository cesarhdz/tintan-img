<?php

namespace CesarHdz\TinTan;

class Image
{

	protected $path;
	protected $presets;

	public function __construct($path, array $presets){
		$this->path = $path;
		$this->presets = $presets;
	}


	public function getPath(){
		return $this->path;
	}

}
