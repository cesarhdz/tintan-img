<?php

namespace CesarHdz\TinTan;

use Intervention\Image\Image;

interface FilterInterface
{

    public function filter(ImageInfo $info, Image $image, Preset $preset);
   
}
