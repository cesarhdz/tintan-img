<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

//@deprecated
class FilterNameMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\FilterNameMatcher');
    }


    function it_should_tell_me_if_a_name_matches_a_given_query_with_numeric_params(){
    	// given
    	$this->setPattern('%dx?%d?');

    	// expect
    	$this->match('150x150')
    		->shouldReturn(true);

    	// expect
    	$this->match('150')
    		->shouldReturn(true);
    }


    function it_should_tell_me_if_a_name_matches_a_given_query_with_string_params(){
    	// given
    	$this->setPattern('watermark-%s-%d');

    	// expect
    	$this->match('watermark-bottom-10')
    		->shouldReturn(true);

    	// expect
    	$this->match('watermark-10-bottom')
    		->shouldReturn(false);
    }

    function it_should_tell_me_if_a_name_matches_a_given_query_with_wildcard_params(){
    	// given
    	$this->setPattern('copy:*');

    	//expect
    	$this->match('copy:Imagen+Ideal')
    		->shouldBe(true);

    	// expect
    	$this->match('copy:/---*/*/*-/')
    		->shouldBe(true);

    }

}
