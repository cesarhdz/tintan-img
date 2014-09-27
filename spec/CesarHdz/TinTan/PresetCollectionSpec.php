<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\FilterInterface;

class PresetCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\PresetCollection');
        $this->get()->shouldBeArray();
    }

    function it_should_be_able_to_add_presets(FilterInterface $filter){
    	// setup
    	$this->count()->shouldReturn(0);

    	// When
    	$this->add('thumbnail', $filter->getWrappedObject());

    	// Then
    	$this['thumbnail']->shouldHaveType('CesarHdz\TinTan\Preset');
    	$this->get()->shouldHaveCount(1);
    }
}
