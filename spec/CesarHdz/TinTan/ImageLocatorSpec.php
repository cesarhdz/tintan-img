<?php

namespace spec\CesarHdz\TinTan;

use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImageLocatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\ImageLocator');
    }


    function it_should_test_image_existence(){
        // Where
        $base = 'image-existence';
        $tree = ['tintan.jpg' => 'image mock'];

        // Setup
        $fs = $this->_fs($base, $tree);
        $this->addDir($fs->dir);
    		
        // Expect
        $this->exists('tintan.jpg')->shouldReturn(true);
    	$this->exists('not-found.jpg')->shouldReturn(false);
    }



    function _fs($base, array $tree){
        $stream = vfsStream::setup($base);

        vfsStream::create($tree, $stream);

        return (object) [
            'stream' => $stream,
            'dir'    => vfsStream::url($base)
        ];
    }
}
