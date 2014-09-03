<?php

namespace CesarHdz\TinTan;


interface ImageFilter
{

    public function filter(ImageInfo $image, Preset $preset, Application $app);
   
}
