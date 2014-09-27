<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;
use Intervention\Image\ImageManager;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';

    const FILTER_SUFFIX = 'FilterInterface';

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
        // All presets must be included using $this->preset() method
        $this['presets'] = new PresetCollection();

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
        $this['sizeFilterInterface'] = $this->share(function(){ 
            return new Filters\SizeFilter();
        });
    }


    public function getFilter($name){
        return  $this[$name . self::FILTER_SUFFIX];
    }

    public function bootstrap()
    {
        $this->validateFields(['dir']);

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

    public function preset($preset, $filter, array $args = array())
    {
        if(! $this->filterExists($filter)){
            throw new Exceptions\ConfigException('Preset ' . $preset,
                "[${filter}] FilterInterface is not available"
            );
        }

        $this['presets']->add($preset, $this->getFilter($filter), $args);

        return $this;
    }

    public function filterExists($name)
    {
        return $this->offsetExists($name . self::FILTER_SUFFIX);
    }


}
