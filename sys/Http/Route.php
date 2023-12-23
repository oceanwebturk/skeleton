<?php namespace OceanWT\Http;
use OceanWT\Support\Traits\Macro;
use OceanWT\Support\Traits\Facade;
class Route
{
 use Facade;
 /**
  * @var array
  */
 protected $patterns=[
  '{:id[0-9]?}' => '([0-9]+)',
  '{:url[0-9]?}' => '([a-z]+)',
 ];

 /**
  * @var array
  */
 protected $routes=[],$params=[],$getConfig=[];

 public function __construct()
 {
  $this->getConfig=\OceanWT\Config::get("routing");
 }

 /**
  * @param  string   $uri    
  * @param  string|array|callable $action 
  * @param  array    $options
  */
 public function get(string $uri,string|array|callable $action,array $options=[])
 {
  $this->addRoute("GET",$uri,$action,$options);
  return new self;
 }
 
 /**
  * @param array    $method 
  * @param string   $uri     
  * @param string|array|callable $action 
  * @param array    $options 
  */
 public static function addRoute(string|array $method,string $uri,string|array|callable $action,array $options=[])
 {
  $this->routes[$method][$this->createPattern($uri)]=[
   'action'=>$action,
   'options'=>$options,
  ];
  return new self;
 }

 public function run()
 {
  if($data=$this->getParams((new Request())->getUrl())){
   $action=$data['props']['action'];
   if(is_callable($action)){
    echo call_user_func($action);
   }
  }
 }

 private function getParams($url)
 {
  foreach($this->routes[(new Request())->method()]as$path=>$props){
   $pattern = '#^'.$path.'$#';
   if(preg_match($pattern,$url,$params)){
    return ['url'=>$params,'props'=>$props];
   }
  }
  return false;
 }

 public function createPattern($value)
 {
  foreach($this->patterns as$name=>$pattern){
   return preg_replace("#".$name."#",$pattern,$value);
  }
 }
}
