<?php

namespace CesarHdz\TinTan;


interface ImageFilter
{

    public function filter(Image $image, Preset $preset, Application $app);
   
}
