<?php namespace OceanWT;

class OceanWT extends Container
{
 
 /**
  * @var \OceanWT\Autoloader
  */
 public static $autoload;
 
 /**
  * @var \OceanWT\Http\Route
  */
 public static $route;

 /**
  * @var array
  */
 protected static $configs=[],$defines=[],$namespaces=[];
 
 /**
  * @param string|null $rootDir
  */
 public function __construct(string $rootDir=null)
 {
  self::$route=new Http\Route();
  self::$autoload=new Autoloader();
  
  !defined('REAL_BASE_DIR') ? define("REAL_BASE_DIR",isset($rootDir) ? $rootDir : $this->getCurrentWorkingDirectory()) : '';

  $this->registerBaseBindings();
 }

 /**
  * @param  array  $configs
  */
 public static function configs(array $configs)
 {
  self::$configs=$configs;
  return new self;
 }
 
 /**
  * @param  array  $defines
  */
 public static function defines(array $defines)
 {
  self::$defines=$defines;
  return new self;
 }
 
 /**
  * @param  array  $namespaces
  */
 public static function namespaces(array $namespaces)
 {
  self::$namespaces=$namespaces;
  return new self;
 }
 
 /**
  * @return void
  */
 public static function registerBaseBindings()
 {
  ini_set("default_charset","UTF-8");
 }
 
 /**
  * @return string
  */
 public static function getCurrentWorkingDirectory()
 {
  return (getcwd() ?: pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_DIRNAME)) . '/';
 }

 /**
  * @return void
  */
 public static function autoloadInit()
 {
  define("GET_DIRS",self::getPaths());
  define("GET_NAMESPACES",self::getNamespaces());
  foreach (GET_NAMESPACES as$prefix=>$path){
   if(isset(GET_DIRS[$prefix])){
    self::$autoload->addNamespace($prefix,GET_DIRS[$prefix]);
   }
  }
 }

 public function run()
 {
  ini_set('display_errors',true);error_reporting(1);
  self::autoloadInit();
  self::$autoload->register();
  if(self::getApplication() && is_callable([self::getApplication(),'execute'])){
   echo call_user_func([self::getApplication(),'execute']);
  }
  self::$route->run();
 }

 public function setErrorHandler()
 {
  set_error_handler("\OceanWT\OceanWT::errorHandler");
  set_exception_handler("\OceanWT\OceanWT::exceptionHandler");
 }

 /**
  * @return array
  */
 public static function getPaths()
 {
  $paths=[
   "APP"=>REAL_BASE_DIR."app/",
   "DATABASE"=>REAL_BASE_DIR."database/",
  ];
  return self::$defines+$paths+[
   "SERVICES"=>REAL_BASE_DIR."srv/",
   "CONFIGS"=>REAL_BASE_DIR."etc/",
   "CONTROLLERS"=>$paths["APP"]."controllers/",
   "MIGRATIONS"=>$paths["DATABASE"]."migrations/",
  ]+(self::getApplication() && is_callable([self::getApplication(),"paths"]) ? call_user_func([self::getApplication(),"paths"]) : []);
 }
 
 /**
  * @return array
  */
 public static function getNamespaces()
 {
  $namespaces=[
   "APP"=>"App\\",
  ];
  return self::$namespaces+$namespaces+[
   "CONFIGS" => "Config\\",
   "SERVICES" => "Services\\",
   "MODELS" => $namespaces["APP"]."Models\\",
   "CONTROLLERS" => $namespaces["APP"]."Controllers\\",
  ]+(self::getApplication() && is_callable([self::getApplication(),"namespaces"]) ? call_user_func([self::getApplication(),"namespaces"]) : []);
 }
}
