<?php 
include(__DIR__."/../bootstrap.php");

$app->macro("demo",function(){
 echo "Hyper View";
});

$app->demo();

$app->run();
