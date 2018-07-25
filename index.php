<?php

use App\Container;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();
$facade = new \App\ContainerFacade($c);

$facade->registerInstance('Concrete', \App\ConcreteClass::class);


$class = $facade
    ->withParameters(array('string', 'another string'))
    ->getInstance('Concrete');

var_dump($class);
