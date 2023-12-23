<?php

defined("REAL_BASE_DIR") or die;
$route=new OceanWT\Http\Route;

$route->get("/",function(){
 echo "Home Page";
});
