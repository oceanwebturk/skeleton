<?php namespace OceanWT\Support\Traits;

trait Facade
{
 public static function __callStatic($method, $parameters)
 {
  return self::useClassName($method, $parameters);
 }
 public function __call($method, $parameters)
 {
  return self::useClassName($method, $parameters);
 }
 public static function useClassName($method, $parameters)
 {
   return self::useClassMethod($method,$parameters);
   return __CLASS__->$method(...$parameters);
 }
}
