<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\Application;
use CesarHdz\TinTan\ImageInfo;
use CesarHdz\TinTan\Preset;
use CesarHdz\TinTan\FilterInterface;

use Intervention\Image\ImageManager;
use Intervention\Image\Image;


class ImageProcessorSpec extends ObjectBehavior
{
    
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageProcessor');
    }

    function it_should_process_an_image_info_and_returns_a_real_image(
        Application $app, 
        Preset $preset,
        ImageManager $manager,
        FilterInterface $filter,
        Image $image
    ){
        // setup
        $manager->make(Argument::any())->willReturn($image->getWrappedObject());
        $app->getFilter(Argument::any())->willReturn($filter->getWrappedObject());
        $filter->filter(Argument::cetera())->willReturn($image->getWrappedObject());

        $this->beConstructedWith($manager->getWrappedObject());

        // Given
        $info = new ImageInfo('dir', 'path', [$preset->getWrappedObject()]);

        // when
        $img = $this->process($info, $app->getWrappedObject());

        // then
        $img->shouldHaveType('Intervention\Image\Image');
    }
}
