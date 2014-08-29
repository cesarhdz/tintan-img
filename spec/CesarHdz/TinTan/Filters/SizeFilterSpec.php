<?php

namespace spec\CesarHdz\TinTan\Filters;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SizeFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldImplement('CesarHdz\TinTan\ImageFilter');
        $this->shouldHaveType('CesarHdz\TinTan\Filters\SizeFilter');
    }
}
