<?php

namespace CesarHdz\TinTan\Filters;

use CesarHdz\TinTan\FilterInterface
  ,	CesarHdz\TinTan\ImageInfo
  ,	CesarHdz\TinTan\Preset
  ,	CesarHdz\TinTan\Application;

class SizeFilter implements FilterInterface
{

	public function filter(ImageInfo $image, Preset $preset, Application $app){

		$args = $preset->getArguments();

		$newImage = $image->get()->fit($args['width'], $args['height']);

		$image->setImage($newImage);

		return $image;
	}

}
