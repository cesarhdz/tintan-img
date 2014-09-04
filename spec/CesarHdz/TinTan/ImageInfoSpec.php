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

    function it_should_read_mime_and_tell_if_a_file_is_an_image(){
    	$this->beConstructedWith($this->_fixture_path('tin-tan.jpg'));

    	$this->getRealPath()->shouldBeString();
    	$this->shouldBeImage();
    }

    function it_should_not_consider_inexistent_files_as_image(){

    	$this->beConstructedWith($this->_fixture_path('no-tan.jpg'));

    	$this->getRealPath()->shouldReturn(false);
    	$this->shouldNotBeImage();
    }

    function it_should_not_consider_other_mimes_as_image(){
    	$this->beConstructedWith(__FILE__);

    	$this->getRealPath()->shouldBeString();
    	$this->shouldNotBeImage();
    }


    function _fixture_path($file){
		return dirname(__FILE__) . '/../../fixtures/' . $file;
    }
}
