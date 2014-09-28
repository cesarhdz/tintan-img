<?php

namespace CesarHdz\TinTan;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController implements ControllerProviderInterface
{

	public function connect(SilexApp $app){
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];

   		$controllers->get('/{uri}', function($uri, Request $request) use($app){
   			// Get presets
   			$imageInfo =  $app['imageResolver']->resolve(
   				$uri, $app['presets']->get()
   			);

			// If we don't have an image, a 404 status code is returned
			if(! $imageInfo->isImage()){
				$app->abort(404, "Image ${uri} doen't exists");
			}

			$image = $app['imageProcessor']->process($imageInfo, $app);

			return $app['imageProcessor']->respond($imageInfo, $image);
		})

		->assert('uri', '[\w\-\._/]+');

		return $controllers;
	}

}
