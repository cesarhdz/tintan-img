<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\Preset;
use CesarHdz\TinTan\FilterInterface;

use CesarHdz\TinTan\ImageInfo;

class ImageResolverSpec extends ObjectBehavior
{
    
    function it_is_initializable_and_have_a_dir()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageResolver');
        $this->getDir()->shouldNotBeNull();
    }


    function it_should_resolve_to_an_image_info(){
    	// expect
    	$this->resolve('some/image-path.jgp', [])
    		->shouldHaveType('CesarHdz\TinTan\ImageInfo');
    }

}
