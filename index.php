<?php

use App\Container;
use App\Val;
use App\NewClass;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();

$c->set('val', Val::class);
$c->set('newClass', NewClass::class);


$newVal = $c->get('val');
$newClass = $c->get('newClass');


$newVal->sayHi();

print '<br>';

$newClass->sayHi();
