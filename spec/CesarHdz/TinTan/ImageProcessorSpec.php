<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class ImageProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageProcessor');
    }


    function it_should_build_an_image_with_a_given_uri(){
    	// setup
    	$this->setPresets([
    		'thumbnail' => [
    			'filter' => 'sizeFilter'
    		],
    		'copyright' => [
    			'filter' => 'textFilter'
    		]
    	]);

    	// expect
    	$this->buildImage('img/tintan.thumbnail.jpg')
    		->shouldHaveType('CesarHdz\TinTan\Image');

    	// expect
    	$this->buildImage('img/tintan.thumbnail.jpg')
    		->getPath()
    		->shouldReturn('img/tintan.jpg');
    }
}
