<?php

use App\Container;
use App\TestClass2;
use App\TestClass;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();
$c->set('Test2', TestClass2::class);

$c->set('Test', function () use ($c) {
    $test2 = $c->get('Test2');
    return new TestClass($test2, 'anemail@gmail.com', '1');
});

$testClass = $c->get('Test');



print_r($testClass->getName());



