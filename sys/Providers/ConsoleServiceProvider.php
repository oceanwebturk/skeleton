<?php 

namespace OceanWT\Providers;

class ConsoleServiceProvider
{
 protected $commands=[
  \OceanWT\Commands\ServeCommand::class,
 ];
}