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

    public function get(){
    	return $this->image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function isImage()
    {
    	// No file, no image
    	if(! $this->getRealPath()){
    		return false;
    	}

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime =  finfo_file($finfo, $this->getRealPath());

		finfo_close($finfo);

		// We only check that mime starts with 'image' prefix
		return (explode('/', $mime)[0] == 'image') ? true : false;
    }
}
