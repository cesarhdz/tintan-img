<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use org\bovigo\vfs\vfsStream;

use CesarHdz\TinTan\ImageProcessor;
use CesarHdz\TinTan\ImageResolver;
use CesarHdz\TinTan\ImageRouter;

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

    function it_should_register_default_dependencies_after_construct(){
        // setup
        $this->dir('./');
        $this->version('1.0');

        // then
        $this['image_processor']->shouldHaveType('CesarHdz\TinTan\ImageProcessor');
        $this['image_router']->shouldHaveType('CesarHdz\TinTan\ImageRouter');
    }

    function it_should_have_fluent_interface_to_set_dir_and_version(){
        // expect
        $this->dir('some/dir')->shouldHaveType('CesarHdz\TinTan\Application');
        $this->version('1.0')->shouldHaveType('CesarHdz\TinTan\Application');

    }


    function it_should_have_a_dir_to_bootstrap(){
        // expect
        $this->shouldThrow('CesarHdz\TinTan\Exceptions\ConfigException')
            ->duringBootstrap();

        // when
        $this->dir('/some/dir');

        // then
        $this->bootstrap()->shouldHaveType('CesarHdz\TinTan\Application');
    }

    function it_should_build_routes_during_bootstrap(ImageRouter $router, ImageResolver $resolver){
        // setup
        $this->dir('/');
        $this['image_router'] = $this->share(function() use ($router){
            return $router->getWrappedObject();
        });        

        $this['image_resolver'] = $this->share(function() use ($resolver){
            return $resolver->getWrappedObject();
        });

        // given
        $this->addRule('thumbnail', 'size', ['width' => 150]);

        // when
        $this->bootstrap();

        // then
        $router->buildRules()->shouldHaveBeenCalled();
        // $this['image_resolver']->getDir()->shouldBe('./');
    }


    function it_should_have_default_filters_after_contructed(){
        // expect
        $this->filterExists('size')->shouldBe(true);
        $this->getFilter('size')->shouldHaveType('CesarHdz\TinTan\FilterInterface');
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
