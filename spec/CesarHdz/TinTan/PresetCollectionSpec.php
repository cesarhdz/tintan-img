<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\FilterInterface;
use CesarHdz\TinTan\Preset;

class PresetCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\PresetCollection');
        $this->get()->shouldBeArray();
    }

    function it_should_be_able_to_add_presets(){
    	// setup
    	$this->count()->shouldReturn(0);

    	// When
        $this->add('thumbnail', 'size');

        // Then
        $this['thumbnail']->shouldHaveType('CesarHdz\TinTan\Preset');
        $this->get()->shouldHaveCount(1);
    }


    function it_should_find_all_presets_by_uri(){
        // expect
        $this->findAllByUri('img/tintan.jpg')->shouldHaveCount(0);

        // given
        $this->add('thumbnail', 'size');

        // when
        $this->findAllByUri('img/tintan.thumbnail.jpg')->shouldHaveCount(1);
    }
}
