<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;
use Symfony\Component\Yaml\Yaml;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';

	protected $dir;


	public function __construct($dir = null, $configFile = null){
		parent::__construct();

		$this->setDir($dir);
		$this->setConfigFile($configFile);
	}

    protected function setDir($dir)
    {
    	$dir = $dir ?: getcwd();
        $this['dir'] = rtrim($dir, '/') . '/';
    }

    protected function setConfigFile($file){
    	$this['config.file'] = $file ?: self::NAME . '.yml';
    }

    public function bootstrap()
    {
        $this->readConfig();
    }


    protected function readConfig(){
    	$file = $this['dir'] . $this['config.file'];

    	$config = Yaml::parse($file);

    	foreach ($config as $key => $value) {
    		$this[$key] = $value;
    	}
    }
}
