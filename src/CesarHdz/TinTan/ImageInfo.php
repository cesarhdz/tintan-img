<?php

namespace CesarHdz\TinTan;

use Intervention\Image\Image;

class ImageInfo extends \SplFileInfo
{

	protected $presets;
	protected $image;

    protected $uri;

	public function __construct($baseDir, $uri, array $presets = array()){
 		parent::__construct($baseDir . $uri);
 		$this->presets = $presets;
        $this->uri = $uri;
	}

	public function getPresets(){
		return $this->presets;
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

    public function getUri()
    {
        return $this->uri;
    }
}
