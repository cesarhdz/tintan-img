<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\FilterRule;
use CesarHdz\TinTan\Route;

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

    function it_should_register_new_rules(){
        // given
        $this->addRule('thumbnail', 'size');
        $this->addRule('grayscale', 'color', ['opacity' => .5]);

        // when
        $rules = $this->getRules();

        // then
        $rules->shouldHaveCount(2);
        $rules[0]->shouldHaveType('CesarHdz\TinTan\FilterRule');
    }


    function it_should_build_rules(){
        // given
        $this->addRule('thumbnail', 'size');
        $this->addRule('{width:num}x{height:num}', 'size', []);

        // when
        $this->buildRules();

        // and
        $rules = $this->getRules();

        //then
        $rules->shouldHaveCount(2);
        
        $rules[0]->getRegex()->shouldReturn('#thumbnail#');
        $rules[1]->getRegex()->shouldReturn('#(\d+)x(\d+)#');

    }

    function it_should_convert_uri_into_a_route(){
        // when
        $info = $this->getRouteFor('/img/name.rule.jpg');

        // then
        $info->shouldHaveType('CesarHdz\TinTan\Route');
        $info->getBasename()->shouldReturn('/img/name.jpg');
        $info->getPatterns()->shouldReturn(['rule']);
    }


    function it_should_return_matched_rules_of_a_route(){
        // given
        $this->addRule('rule', 'filter');
        $this->addRule('{width:num}x{height:num}', 'size', []);

        // and
        $this->buildRules();

        // when
        $rules = $this->getRulesForRoute(
            new Route('/img/name.150x250.jpg', '/img/name.jpg', ['150x250'])
        );

        // then
        $rules[0]->getParams()['width']->shouldReturn('150');
        $rules[0]->getParams()['height']->shouldReturn('250');
    }
}
