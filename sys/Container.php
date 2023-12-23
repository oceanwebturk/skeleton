<?php namespace OceanWT;

class Container
{
 use Support\Traits\Macro,Support\Traits\Facade;
 /**
  * @var array
  */
 protected $bindings=[];
 
 /**
  * @var string|null
  */
 protected static $application="Web";

 /**
  * @var array
  */
 protected static $appNamespaces=[
  __NAMESPACE__.'\\Application\\',
 ];
 
 /**
  * @param  object $abstract 
  * @param  array  $callback
  */
 public function bind(string|object $abstract,string|callable|array $callback)
 {
   $this->bindings[$abstract]=compact('callback');
 }
 
 /**
  * @param  object $name  
  * @param  array  $params
  * @return mixed
  */
 public function make(string|object $name,array $params=[])
 {
  if(isset($this->bindings[$name])){
   $arr=$this->bindings[$name]['callback'];
   if(is_object($arr)){
    echo call_user_func($arr);
   }
  }
 }
 
 /**
  * @param string $namespace
  */
 public static function addAppNamespace(string $namespace)
 {
  self::$appNamespaces[]=$namespace;
  return new self;
 }

 /**
  * @param string|object $name
  */
 public static function setApplication(string|object $name)
 {
  self::$application=$name;
  return new self;
 }

 public static function getApplication(...$params)
 {
  if(!is_null(self::$application)){
   foreach(self::$appNamespaces as$namespace){
    $class=$namespace.self::$application;
    return class_exists($class) ? new $class($params) : '';
   }
  }else{
   return false;
  }
 }

 public function getPars()
 {
 	print_r($_SERVER);
 }

}
