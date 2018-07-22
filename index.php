<?php

use App\Container;

require_once __DIR__ . '/vendor/autoload.php';

$c = new Container();

try {
    $c->bind('ConcreteClassInterface', \App\ConcreteClass::class);
} catch (Exception $e) {
    print $e->getMessage() . '<br>';
}

try {
    $c->set('ConcreteClassInterface', \App\ConcreteClass::class);
} catch (Exception $e) {
    print $e->getMessage() . '<br>';
}

$newVal = $c->get('ConcreteClassInterface');

$newVal->sayHi();
print '<br>';
var_dump($c);