<?php

namespace CesarHdz\TinTan\Filters;

use Intervention\Image\Image;

use CesarHdz\TinTan\FilterInterface
  ,	CesarHdz\TinTan\ImageInfo
  ,	CesarHdz\TinTan\Preset;

class SizeFilter implements FilterInterface
{

	public function filter(ImageInfo $image, Image $image, Preset $preset){
		$args = $preset->getArguments();

		$newImage = $image->get()->fit($args['width'], $args['height']);

		$image->setImage($newImage);

		return $image;
	}

}
