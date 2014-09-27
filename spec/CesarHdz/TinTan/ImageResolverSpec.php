<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\Preset;
use CesarHdz\TinTan\PresetCollection;
use CesarHdz\TinTan\ImageInfo;

class ImageResolverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageResolver');
    }


    function it_should_resolve_to_an_image_info(PresetCollection $presets){
    	// expect
    	$this->resolve('some/image-path.jgp', $presets->getWrappedObject())
    		->shouldHaveType('CesarHdz\TinTan\ImageInfo');


    }

    function it_should_resolve_an_image_with_presets(PresetCollection $presets, Preset $preset){
    	// given
    	$uri = 'tin-tan/image-path.thumbnail.jgp';
    	$presets->get()->willReturn(array(
    		$preset->getWrappedObject()
    	));


    	// when
    	$info = $this->resolve($uri, $presets->getWrappedObject());

    	// then
    	$info->presets()->shouldHaveCount(1);
    	$info->getPathName()->shouldReturn('tin-tan/image-path.jpg');
    }
}
