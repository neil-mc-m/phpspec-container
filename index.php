<?php

use App\Container;
use App\EventDispatcherServiceProvider;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();
$c->register('EventDispatcher', new EventDispatcherServiceProvider());
// var_dump($c);
$e = $c->get('EventDispatcher');
// var_dump($e);// instance of symfony eventdispatcher
