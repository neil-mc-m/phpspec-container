<?php

use App\Container;
use App\EventDispatcherServiceProvider;
use App\TestClass;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();
$c->register('EventDispatcher', new EventDispatcherServiceProvider());
$c->set('TestClass', TestClass::class);
$e = $c->get('EventDispatcher');
var_dump($e);

$test = $c
    ->withArguments(array('neil', 'neilo2000@gmail.com'))
    ->build('TestClass');

var_dump($test);
var_dump($c);