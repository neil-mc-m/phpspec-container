<?php

use App\Container;
use App\EventDispatcherServiceProvider;
use App\TestClass;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();

$c->register('EventDispatcher', new EventDispatcherServiceProvider());


$c->set('TestClass', TestClass::class);


$e = $c->get('EventDispatcher');


$test = $c
    ->withArguments(array('neil', 'neilo2000@gmail.com'))
    ->build('TestClass');

echo '<pre style="direction: ltr; text-align: left">';
print_r($c);
echo '</pre>';