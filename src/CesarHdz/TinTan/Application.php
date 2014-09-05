<?php

namespace CesarHdz\TinTan;

use Silex\Application as Silex;

class Application extends Silex
{

	const NAME = 'tintan';
	const VERSION = '0.1';

	public function __construct(array $config = array()){
		parent::__construct($config);
	}

    protected function dir($dir)
    {
    	$dir = $dir ?: getcwd();
        $this['dir'] = rtrim($dir, '/') . '/';

        return $this;
    }

    public function bootstrap()
    {

    }
}
