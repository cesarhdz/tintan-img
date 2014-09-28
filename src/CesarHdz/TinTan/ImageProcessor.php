<?php

namespace CesarHdz\TinTan;

use Intervention\Image\ImageManager;

class ImageProcessor
{

    private $manager;

	public function __construct(ImageManager $manager = null, $dir = null){
		$presets = array();

        $this->manager = $manager ?: new ImageManager();
	}

    /**
     * Transofrm image info and filters into an image
     * 
     * @param  ImageInfo        $img [description]
     * @param  Application      $app [description]
     * @return [type]           [description]
     */
    public function process(ImageInfo $info, Application $app)
    {
        $presets = $info->getPresets();
        $img = $this->manager->make($info->getRealPath());

        foreach ($presets as $preset){
            $filter = $app->getFilter($preset->getFilterName());

            if(!$filter){
                throw new \Exception($preset->getFilterName() . 'Filter not found');
            }

            $img = $filter->filter($info, $img, $preset);
        }

        return $img;
    }

}
