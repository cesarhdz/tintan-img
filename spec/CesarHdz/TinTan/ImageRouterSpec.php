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

    function it_should_have_digit_and_alpha_definitions(){
    	// expect
    	$this->getDefinition('num')->shouldBeString();
    	$this->getDefinition('alpha')->shouldBeString();
    }


    // function it_should_convert_an_uri_into_rules(){
    //     // when
    //     $rules = $this->matchRules(
    //         '/img/name.rule.jpg', 
    //         $this->getDefaultRules()
    //     );

    //     //then
    //     $rules->shouldBeArray();
    //     $rules->shouldHaveCount(1);
    // }


    function it_should_extract_parameters_from_uri(){
        // when
        $rules = $this->matchRules(
            '/img/name.150x250.jpg',
            $this->getDefaultRules()
        );

        // then
        $rules[0]['params']['width']->shouldReturn('150');
        $rules[0]['params']['height']->shouldReturn('250');

    }


    function getDefaultRules(){ return [
        new FilterRule('rule', 'filter', []),
        new FilterRule('{width:num}x{height:num}', 'size', []),
    ];}
}
