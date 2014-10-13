<?php

namespace spec\CesarHdz\TinTan\Filters;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;



class GrayscaleFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\Filters\GrayscaleFilter');
        $this->shouldHaveType('CesarHdz\TinTan\FilterInterface');
    }
}
