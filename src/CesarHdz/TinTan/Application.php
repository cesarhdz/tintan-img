<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;
use Intervention\Image\ImageManager;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';

    const FILTER_SUFFIX = 'FilterImage';

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
        $this['imageController'] = function($app){
            return new ImageController();
        };

        // Manaer 
        $this['imageManager'] = $this->share(function($app){
            $key = 'imageManager.adapter';
            $config = array();

            if(array_key_exists($key, $this)){
                $config['adapter'] = $this[$key];
            }

            return new ImageManager($config);
        });

        // ImageProcessor
        $this['imageProcessor'] = $this->share(function($app){
            $processor = new ImageProcessor($app['imageManager'], $app['dir']);

            return $processor;
        });

        // Add default filters
        $this['sizeFilterImage'] = $this->share(function(){ 
            return new Filters\SizeFilter();
        });


        // Image Resolver is added
        $this['imageResolver'] = $this->share(function(){
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
        $this->extend('imageResolver', function ($resolver, $app){
            $resolver->setDir($app['dir']);
            return $resolver;
        });

        $this->mount('/', $this['imageController']);

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

        $this['imageResolver']->addPreset($name, $filter, $args);

        return $this;
    }

    public function filterExists($name)
    {
        return $this->offsetExists($name . self::FILTER_SUFFIX);
    }


}
