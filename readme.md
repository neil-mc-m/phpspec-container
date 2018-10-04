[![CodeFactor](https://www.codefactor.io/repository/github/neil-mc-m/phpspec-container/badge)](https://www.codefactor.io/repository/github/neil-mc-m/phpspec-container)
[![Build Status](https://travis-ci.org/neil-mc-m/phpspec-container.svg?branch=master)](https://travis-ci.org/neil-mc-m/phpspec-container)
[![Coverage Status](https://coveralls.io/repos/github/neil-mc-m/phpspec-container/badge.svg?branch=master)](https://coveralls.io/github/neil-mc-m/phpspec-container?branch=master)
- a simple PHP service container to manage classes and their dependencies.


use like this :

```$c = new Container();
$c->set('Test2', TestClass2::class);

$c->set('Test', function () use ($c) {
    $test2 = $c->get('Test2');
    return new TestClass($test2, 'anemail@gmail.com', '1');
});

$testClass = $c->get('Test');```

