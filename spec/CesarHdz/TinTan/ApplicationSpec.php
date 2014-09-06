<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;

class ApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('CesarHdz\TinTan\Application');
        $this->shouldHaveType('Silex\Application');
    }

    function it_should_be_constructed_with_a_config_array(){
    	$this->beConstructedWith([
            'dir' => 'some/dir',
            'version' => '1.0'
        ]);

        $this['version']->shouldBe('1.0');
        $this['dir']->shouldBe('some/dir');
    }


    function it_should_have_fluent_interface_to_set_dir_and_version(){
        // expect
        $this->dir('some/dir')->shouldHaveType('CesarHdz\TinTan\Application');
        $this->version('1.0')->shouldHaveType('CesarHdz\TinTan\Application');

    }

    function it_should_register_image_manager_as_service_after_bootstrap(){
        // setup
        $this->beConstructedWith([
            'dir' => './',
        ]);

        //when
        $this->bootstrap();

        // then
        $this['imageProcessor']->shouldHaveType('CesarHdz\TinTan\ImageProcessor');
    }


    function it_should_register_presets_with_apply_method(){

        $this->preset('thumbnail-mini', 'SizeFilter', ['width' => 150]);


        $this['presets'][0]->shouldHaveType('CesarHdz\TinTan\Preset');
        $this['presets'][0]->getName()->shouldReturn('thumbnail-mini');

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
