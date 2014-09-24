<?php

namespace CesarHdz\TinTan;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ImageController implements ControllerProviderInterface
{

	public function connect(SilexApp $app){
		$app->get('/{image}', function(){

		});
	}

}
