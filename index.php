<?php

use App\Container;
use App\ConcreteClass;
use App\ServiceProvider;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();

$c->set('Concrete', ConcreteClass::class);
$c->set('ServiceProviderInterface', ServiceProvider::class);

$class = $c->get('Concrete');


var_dump($class);
