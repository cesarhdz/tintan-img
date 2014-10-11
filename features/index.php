<?php 
/**
 * This file will trigger the server
 */

require '../vendor/autoload.php';

use CesarHdz\TinTan\Application;


$app = new Application([
	'image.library' => 'imagik'
]);

$app->version('1.0')->dir('./');


$app->addRule('thumbnail-mini', 'size', [
		'width' => 150,
		'height' => 150
	])
	->addRule('{width:num}x{height:num}', 'size');



$app->bootstrap();
$app->run();