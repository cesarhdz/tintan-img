<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\ImageFilter;
use CesarHdz\TinTan\Application;
use CesarHdz\TinTan\Preset;
use CesarHdz\TinTan\ImageInfo;



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
    			'filter' => 'size'
    		],
    		'copyright' => [
    			'filter' => 'text'
    		]
    	]);

    	// expect
    	$this->buildImageInfo('img/tintan.thumbnail.jpg')
    		->shouldHaveType('CesarHdz\TinTan\ImageInfo');

    	// expect
    	$this->buildImageInfo('img/tintan.thumbnail.jpg')
    		->getPathName()
    		->shouldReturn('img/tintan.jpg');
    }


    function it_should_process_an_image_that_have_presets(ImageFilter $filter){
    	// setup application
    	$app = new Application();
    	$app['sizeFilter'] = function($app) use($filter){
    		// Reveal wrapped object
    		return $filter->getWrappedObject();
    	};

    	// given
    	$presets = array(
    		new Preset('thumbnail',  'sizeFilter', ['width' => 150, 'height' => 150])
    	);

    	$image = new ImageInfo('some/path.jpg', $presets);

    	// when
    	$this->process($image, $app)->shouldImplement('CesarHdz\TinTan\ImageInfo');

    	// expect
    	$filter->filter($image, $presets[0], $app)->shouldHaveBeenCalled();
    }
}
