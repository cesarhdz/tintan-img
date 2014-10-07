<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\Application;
use CesarHdz\TinTan\ImageInfo;
use CesarHdz\TinTan\FilterRule;
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
        FilterRule $rule,
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
        $info = new ImageInfo('dir', 'path');

        // when
        $img = $this->process(
            $info, 
            [$rule->getWrappedObject()], 
            $app->getWrappedObject()
        );

        // then
        $img->shouldHaveType('Intervention\Image\Image');
    }



    function it_should_return_an_image_response(Image $image){
        $image->encode(Argument::any())->willReturn($image->getWrappedObject());
        $image->getEncoded()->willReturn($image->getWrappedObject());
        $image->__toString()->willReturn('Image Encoded');

        $this->respond(new ImageInfo('a', 'b'), $image->getWrappedObject())
            ->shouldHaveType('Symfony\Component\HttpFoundation\Response');
    }
}
