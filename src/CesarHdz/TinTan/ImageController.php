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

   		$controllers->get('/{route}', function(Route $route, Request $request) use($app){
   			$rules = $app['image_router']->getRulesForRoute($route);
   			$imageInfo = $app['image_resolver']->resolve($route->getBasename());

			// If we don't have an image, a 404 status code is returned
			if(! $imageInfo->isImage()){
				$app->abort(404, 'Image ' . $route->getUri() . " doesn't exists");
			}

			$image = $app['image_processor']->process($imageInfo, $rules, $app);

			return $app['image_processor']->respond($imageInfo, $image);
		})

		->assert('route', '[\w\-\._/]+')

		->convert('route', function($uri) use($app){

			return $app['image_router']->getRouteFor($uri);

		});

		return $controllers;
	}

}
