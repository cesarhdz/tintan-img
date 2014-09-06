<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;
use Intervention\Image\ImageManager;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';


    public function __construct(array $config = array()){
        parent::__construct($config);

        // All presets must be included using $this->preset() method
        $this['presets'] = array();
    }

    public function dir($dir)
    {
    	$dir = $dir ?: getcwd();
        $this['dir'] = rtrim($dir, '/') . '/';

        return $this;
    }

    public function version($version){
        $this['version'] = $version;

        return $this;
    }

    public function bootstrap()
    {
        $this['imageManager'] = $this->share(function($app){

            $key = 'imageManager.adapter';
            $config = array();

            if(array_key_exists($key, $this)){
                $config['adapter'] = $this[$key];
            }

            return new ImageManager($config);
        });


        // Set Image Manager
        $this['imageProcessor'] = $this->share(function($app){
            $processor = new ImageProcessor($app['dir']);
            $processor->setPresets($app['presets']);
            $processor->setManager($app['imageManager']);

            return $processor;
        });
    }

    public function preset($preset, $filter, array $args = array())
    {
        $this['presets'] = array_merge(
            $this['presets'], 
            [new Preset($preset, $filter, $args)]
        );
    }
}
