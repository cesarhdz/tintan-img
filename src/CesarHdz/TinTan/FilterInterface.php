<?php

namespace CesarHdz\TinTan;


interface FilterInterface
{

    public function filter(ImageInfo $image, Preset $preset, Application $app);
   
}
