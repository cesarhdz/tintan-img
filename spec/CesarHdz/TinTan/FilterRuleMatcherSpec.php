<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterRuleMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\FilterRuleMatcher');
    }

    function it_should_have_digit_and_alphabetic_definitions(){
    	// expect
    	$this->getDefinition('numeric')->shouldBeString();
    	$this->getDefinition('alphabetic')->shouldBeString();
    }
}
