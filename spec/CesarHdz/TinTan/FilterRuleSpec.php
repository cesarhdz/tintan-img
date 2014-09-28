<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterRuleSpec extends ObjectBehavior
{
    function it_is_initializable_with_a_pattern_filter_name_and_arguments()
    {
    	$this->beConstructedWith('pattern', 'filterName', ['params' => 1]);
        $this->shouldHaveType('CesarHdz\TinTan\FilterRule');


        $this->getPattern()->shouldReturn('pattern');
        $this->getFilterName()->shouldReturn('filterName');
        $this->getParams()->shouldReturn(['params' => 1]);
    }

}
