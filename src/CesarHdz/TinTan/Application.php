<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;
use Intervention\Image\ImageManager;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';

    const FILTER_SUFFIX = '_filter_image';

    public function __construct(array $config = array()){
        parent::__construct($config);
        $this->setDefaultConfig();
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


    protected function setDefaultConfig(){
        // Image controller will handle all requests
        $this['image_controller'] = function($app){
            return new ImageController();
        };

        // Manaer 
        $this['image_manager'] = $this->share(function($app){
            $key = 'imageManager.adapter';
            $config = array();

            if(array_key_exists($key, $this)){
                $config['adapter'] = $this[$key];
            }

            return new ImageManager($config);
        });

        // ImageProcessor
        $this['image_processor'] = $this->share(function($app){
            $processor = new ImageProcessor($app['image_manager'], $app['dir']);

            return $processor;
        });

        // Add default filters
        $this['size_filter_image'] = $this->share(function(){ 
            return new Filters\SizeFilter();
        });


        // Image Resolver is added
        $this['image_resolver'] = $this->share(function(){
            return new ImageResolver();
        });
    }


    public function getFilter($name){
        return  $this[$name . self::FILTER_SUFFIX];
    }

    public function bootstrap()
    {
        $this->validateFields(['dir']);

        // Match imageresolver dir
        $this->extend('image_resolver', function ($resolver, $app){
            $resolver->setDir($app['dir']);
            return $resolver;
        });

        $this->mount('/', $this['image_controller']);

        return $this;
    }


    protected function validateFields(array $fields){
        array_map(function($field){
            if(! isset($this->values[$field])){
                throw new Exceptions\ConfigException('version', 
                    "It's required but it have not been defined, you can set using \$app['${field}'] = <value>"
                );
            }
        }, $fields);
    }

    public function addPreset($name, $filter, array $args = array())
    {
        if(! $this->filterExists($filter)){
            throw new Exceptions\ConfigException('Preset ' . $name,
                "[${filter}] FilterImage is not available"
            );
        }

        $this['image_resolver']->addPreset($name, $filter, $args);

        return $this;
    }

    public function filterExists($name)
    {
        return $this->offsetExists($name . self::FILTER_SUFFIX);
    }


}
