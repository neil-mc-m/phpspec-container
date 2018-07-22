<?php

use App\Container;
use App\Val;
use App\NewClass;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();


$c->set('val', Val::class);
$c->set('newClass', NewClass::class);

try {
    $newVal = $c->get('object');
    $newClass = $c->get('newClass');
} catch (Exception $e) {
    print $e->getMessage();
}



$newVal->sayHi();

print '<br>';

$newClass->sayHi();
