<?php

namespace CesarHdz\TinTan;

use Intervention\Image\ImageManager;
use Intervention\Image\Image;

use Symfony\Component\HttpFoundation\Response;

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


    public function respond(ImageInfo $info, Image $image)
    {
        // Adding response
        $format = $info->getExtension();
        $data = $image->encode($format);

        $response = new Response($data->getEncoded());
        $response->headers->set('Content-Type', "image/{$format}");

        return $response;
    }
}
