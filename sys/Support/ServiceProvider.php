<?php

namespace OceanWT\Support;

class ServiceProvider
{
    use Traits\Macro;
    /**
     * @var \OceanWT\OceanWT
     */
    protected  $app;
    
    /**
     * @var \OceanWT\Http\Route
     */
    protected  $route;
    
    /**
     * @var \OceanWT\Database\DB
     */
    public $db;

    /**
     * @var array
     */
    public static $providers = [];
    
    /**
     * @param \OceanWT\OceanWT $app
     */
    public function __construct($app=null)
    {
     $this->app=$app;
     $this->db=new \OceanWT\Database\DB();
     $this->route=new \OceanWT\Http\Route();
    }

    public static function default()
    { 
        self::$providers = [];
        return new self();
    }

    /**
     * @param  array  $providers
     */
    public function merge(array $providers)
    {
        self::$providers = array_merge(self::$providers, $providers);
        return new self();
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return self::$providers;
    }
    
    /**
     * @param  string $name
     */
    public function loadRoutes(string $name)
    {
        require($name);
    }

    /**
     * @param  string $path
     * @param  string $namespace
     */
    public function loadViews(string $path,string $namespace)
    {
     View::$paths[$namespace]=$path;
    }
    
    /**
     * @param  string $methodName
     */
    public function providerLists(string $methodName="boot")
    {
     foreach(self::$providers as$provider){
      if(class_exists($provider)){
        $class=new $provider();
        return $class->$methodName();
      }
     }
    }
}
