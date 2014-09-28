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

    function it_should_resolve_an_image_with_presets_applied(FilterInterface $filter){
        // given
        $this->beConstructedWith('/img');
    	$uri = 'tin-tan/image-path.thumbnail.jpg';

    	$presets = [
            new Preset('thumbnail', $filter->getWrappedObject())
        ];

    	// when
    	$info = $this->resolve($uri, $presets);

    	// then
    	$info->getPresets()->shouldHaveCount(1);
        $info->getUri()->shouldReturn('tin-tan/image-path.jpg');
    	$info->getPathName()->shouldReturn('/img/tin-tan/image-path.jpg');
    }
}
