<?php

namespace CesarHdz\TinTan\Exceptions;

class ConfigException extends \InvalidArgumentException{


	public function __construct($field, $error){
		parent::__construct("[${field}] is invalid. ${error}");
	}


}