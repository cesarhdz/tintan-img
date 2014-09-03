<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Intervention\Image\Image;

class ImageInfoSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
		$this->beConstructedWith('/fake/path', []);
        $this->shouldHaveType('CesarHdz\TinTan\ImageInfo');
        $this->shouldBeAnInstanceOf('SplFileInfo');
    }

    function it_should_have_image_setter_and_getter(Image $image){
    	// setup
    	$this->beConstructedWith('/fake/path.jpg');

    	//assert
    	$this->exists()->shouldReturn(false);

    	// given
    	$this->setImage($image->getWrappedObject());


    	// then
    	$this->getImage()->shouldHaveType('Intervention\Image\Image');
    	$this->exists()->shouldReturn(true);


    }
}
