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

    function it_should_be_constructed_with_a_dir(){
    	$this->beConstructedWith('/some/dir');

    	$this['dir']->shouldBe('/some/dir/');
    }


    function it_should_read_configuration_from_file(){

    	// where
    	$config = <<<EOD
version: '1.0'
cache.dir: /tmp/tin-tan/

filters:
  - CesarHdz//TinTan//Thumbnail 
  - CesarHdz//TinTan//Copyright
EOD;

		//setup
		$fs = $this->_mock_fs('first-config', ['tintan.yml' => $config]);

    	// when reading config return self to allow fluent interface
    	$this->beConstructedWith($fs->dir);

    	// and
    	$this->bootstrap();

    	// then
    	$this['version']->shouldBe('1.0');
    	$this['cache.dir']->shouldBe('/tmp/tin-tan/');
    	$this['filters']->shouldBeArray();
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
