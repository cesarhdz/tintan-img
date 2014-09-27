<?php

namespace CesarHdz\TinTan\Filters;

use CesarHdz\TinTan\FilterInterface
  ,	CesarHdz\TinTan\ImageInfo
  ,	CesarHdz\TinTan\Preset
  ,	CesarHdz\TinTan\Application;

class SizeFilter implements FilterInterface
{

	public function filter(ImageInfo $image, Preset $preset, Application $app){
		$image->setImage($image->get()->fit(250, 200));

		var_dump('Filtering');

		return $image;
	}

}
