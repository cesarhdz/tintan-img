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
        // setup:
        $fs = $this->_mock_fs('image-existence', [
            'tintan.jpg' => 'image mock'
        ]);
        
        // when:
        $this->addDir($fs->dir);
            
        // then:
        $this->exists('tintan.jpg')->shouldReturn(true);
        $this->exists('not-found.jpg')->shouldReturn(false);
    }


    function it_should_find_an_image(){
        // setup
        $fs = $this->_mock_fs('img', [
            'tintan.jpg' => 'image mock'
        ]);


        // when:
        $this->addDir($fs->dir);

        // Setup
        $this->get('tintan.jpg')->getContents()->shouldReturn('image mock');
        $this->get('not-found.jpg')->shouldBe(null);
    }



    function _mock_fs($base, array $tree){
        $stream = vfsStream::setup($base);

        vfsStream::create($tree, $stream);

        return (object) [
            'stream' => $stream,
            'dir'    => vfsStream::url($base)
        ];
    }
}
