<?php 
define("REQUIRED_PHP_VERSION","7.4");
if(phpversion()<REQUIRED_PHP_VERSION){
 $message="Your PHP Version needs to be ".REQUIRED_PHP_VERSION." and above";
 $file=__FILE__;
 $line=__LINE__;
 include(__DIR__."/Views/layout-handler.php");
 exit;
}
if(!function_exists("request_uri"))
{
function request_uri($path = __DIR__)
{
    $root = "";
    $dir = str_replace('\\', '/', realpath($path));
    if(!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER['CONTEXT_DOCUMENT_ROOT']));
    } else {
        $root .= substr($dir, strlen($_SERVER['DOCUMENT_ROOT']));
    }
    return $root;
}	
}

if(!function_exists("minify"))
{
function minify($data, $st = true)
{
    if($st) {
        return preg_replace(array(
        '/ {2,}/',
        '/<!--.*?-->|\t|(?:\r?\n[ \t]*)+/s'
        ), array(' ',''), $data);
    } else {
        return $data;
    }
}	
}

if(defined('MANUAL_AUTOLOAD')){
require(__DIR__."/Autoloader.php");
$autoloader=new OceanWT\Autoloader();
$autoloader->addNamespace("OceanWT\\",__DIR__."/");
$autoloader->register();
}
