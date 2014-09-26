<?php

namespace CesarHdz\TinTan;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;

class ImageController implements ControllerProviderInterface
{



	public function connect(SilexApp $app){
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

   		$controllers->get('/{uri}', function($uri, Request $request) use($app){
			$image = $app['imageProcessor']->buildImageInfo($uri);

			// If we don't have an image, a 404 status code is returned
			if(! $image->exists()){
				$app->abort(404, "Image ${uri} doen't exists");
			}


			return $image->getImage()->response();
		})

		->assert('uri', '[\w\-\._/]+');

		return $controllers;
	}

}
