<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Intervention\Image\ImageManagerStatic as IMS;

class ImageInfoSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
		$this->beConstructedWith('/fake/path', []);
        $this->shouldHaveType('CesarHdz\TinTan\ImageInfo');
        $this->shouldBeAnInstanceOf('SplFileInfo');
    }
}
