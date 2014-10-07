<?php

namespace CesarHdz\TinTan\Filters;

use Intervention\Image\Image;

use CesarHdz\TinTan\FilterInterface
  ,	CesarHdz\TinTan\FilterRule
  ,	CesarHdz\TinTan\ImageInfo;

class SizeFilter implements FilterInterface
{

	public function filter(ImageInfo $image, Image $image, FilterRule $rule){
		$args = $rule->getParams();

		return $image->fit($args['width'], $args['height']);
	}

}
