<?php

namespace CesarHdz\TinTan;

class ImageInfo extends \SplFileInfo
{

	protected $presets;
	protected $image;

	public function __construct($file, array $presets = array()){
 		parent::__construct($file);
 		$this->presets = $presets;
	}

	public function getPresets(){
		return $this->presets;
	}

	// public function setImage(Image $image){
	// 	$this->image = $image;
	// }

	// public function getImage(){
	// 	return $this->image();
	// }
}
