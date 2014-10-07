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
        $rule = new FilterRule('{width:num}x{height:num}', 'size', []);

        // when
        $rule = $this->buildRule($rule);

        //then
        $rule->shouldHaveType('CesarHdz\TinTan\FilterRule');
        $rule->getArguments()->shouldBeArray();
        $rule->getArguments()->shouldHaveCount(2);

        $rule->getRegex()->shouldReturn('#(\d+)x(\d+)#');
    }

    function it_should_convert_uri_into_a_route(){
        // when
        $info = $this->getRouteFor('/img/name.rule.jpg');

        // then
        $info->shouldHaveType('CesarHdz\TinTan\Route');
        $info->getBasename()->shouldReturn('/img/name.jpg');
        $info->getPatterns()->shouldReturn(['rule']);
    }


    function it_should_convert_an_uri_into_rules(){
        // when
        $rules = $this->matchRules(
            new Route('/img/name.rule.jpg', '/img/name.jpg', ['rule']), 
            $this->getDefaultRules()
        );

        //then
        $rules->shouldBeArray();
        $rules->shouldHaveCount(1);
    }


    function it_should_extract_parameters_from_uri(){
        // when
        $rules = $this->matchRules(
            new Route('/img/name.150x250.jpg', '/img/name.jpg', ['150x250']), 
            $this->getDefaultRules()
        );

        // then
        $rules[0]->getParams()['width']->shouldReturn('150');
        $rules[0]->getParams()['height']->shouldReturn('250');
    }


    function getDefaultRules(){ 
        $rule1 = new FilterRule('rule', 'filter', []);
        $rule1->setRegex('#rule#');

        $rule2 = new FilterRule('{width:num}x{height:num}', 'size', []);
        $rule2->setRegex('#(\d+)x(\d+)#');
        $rule2->setArguments(['width', 'height']);

        return [$rule1, $rule2];
    }
}
