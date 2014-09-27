<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;

use CesarHdz\TinTan\ImageProcessor;

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
        $this->dir('./');
        $this->version('1.0');

        //when
        $this->bootstrap();

        // then
        $this['imageProcessor']->shouldHaveType('CesarHdz\TinTan\ImageProcessor');
    }


    function it_should_register_presets_with_apply_method(ImageProcessor $processor){
        // setup
        $this->filterExists('size')->shouldBe(true);
        $this['imageProcessor'] = function($app) use($processor){
            return $processor->getWrappedObject();
        };

        // When
        $this->preset('thumbnail', 'size', ['width' => 150]);

        // Then
        $processor->addPreset(
            'thumbnail', 
            Argument::type('CesarHdz\TinTan\Filters\SizeFilter'), 
            ['width' => 150]
        )->shouldHaveBeenCalled();
        
    }

    // function it_should_have_a_dir_and_version_in_order_to_be_bootstrapped(){
        
    //     // expect
    //     $this->shouldThrow('CesarHdz\TinTan\Exceptions\ConfigException')
    //         ->duringBootstrap();

    //     // when
    //     $this->version('1.0');
    //     $this->dir('/some/dir');


    //     // then
    //     $this->bootstrap()->shouldHaveType('CesarHdz\TinTan\Application');

    // }


    function it_should_have_default_filters_after_contructed(){
        // expect
        $this->filterExists('size')->shouldBe(true);
        $this->getFilter('size')->shouldHaveType('CesarHdz\TinTan\ImageFilter');
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
