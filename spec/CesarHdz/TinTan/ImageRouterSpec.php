<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\FilterRule;

class ImageRouterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageRouter');
    }

    function it_should_have_digit_and_alphabetic_definitions(){
    	// expect
    	$this->getDefinition('numeric')->shouldBeString();
    	$this->getDefinition('alphabetic')->shouldBeString();
    }


    function it_should_convert_an_uri_into_parameters(){
    	// given
        $rules = [
            new FilterRule('rule', 'filter', []),
            new FilterRule('noMatch', 'filter', []),
            new FilterRule('{width}x{height}', 'filter', []),
        ];

    	// when
    	$rules = $this->matchRules('/img/name.rule.jpg', $rules);

    	//then
    	$rules->shouldBeArray();
    	$rules->shouldHaveCount(1);
    }
}
