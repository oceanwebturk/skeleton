<?php namespace OceanWT;

class Config{

 use Support\Traits\Macro,Support\Traits\Facade;

 /**
  * @var array
  */
 protected static $paths=[
  GET_DIRS["CONFIGS"]
 ];

 public function addPath($path)
 {
  self::$paths[]=$path;
  return new self;
 }

 public static function get($name)
 {

 }

}
