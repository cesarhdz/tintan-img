<?php

namespace CesarHdz\TinTan;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ImageController implements ControllerProviderInterface
{

	public function connect(SilexApp $app){
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

   		$controllers->get('/{image}', function($image){
			var_dump($image);
		})

		->assert('image', '[\w\-\._/]+');

		return $controllers;
	}

}
