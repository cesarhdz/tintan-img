<?php

namespace CesarHdz\TinTan;

use Intervention\Image\Image;

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


	public function setImage(Image $image){
		$this->image = $image;
	}


    public function exists()
    {
    	return ($this->image) ? true : false;
    }

    public function getImage()
    {
        return $this->image;
    }
}
