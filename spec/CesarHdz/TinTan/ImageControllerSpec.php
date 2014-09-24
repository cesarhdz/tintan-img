<?php

namespace spec\CesarHdz\TinTan;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use CesarHdz\TinTan\Application;


class ImageControllerSpec extends ObjectBehavior
{
    function it_is_initializable_and_implements_controller_provider_interface()
    {
    	// expect:
        $this->shouldHaveType('CesarHdz\TinTan\ImageController');
        $this->shouldImplement('Silex\ControllerProviderInterface');
    }


    function it_should_register_a_global_route_for_all_images(Application $app){
    	// when:
    	$this->connect($app->getWrappedObject());

    	// then:
    	$app->get(Argument::exact('/{image}'), Argument::any())->shouldHaveBeenCalled();
    }


}
