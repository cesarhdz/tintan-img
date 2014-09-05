<?php 
/**
 * This file will trigger the server
 */

require '../../vendor/autoload.php';

use CesarHdz\TinTan\Application;


$app = new Application('/my/path', [
	'image.library' => 'imagik'
]);


$app->use('thumbnail-mini', 'SizeFilter', [
		'width' => 150
	]);

	// ->use('{i:width}', 'SizeFilter')

	// ->use('{i:width}x{i:height}', 'SizeFilter');



$app->bootstrap();
$app->run();