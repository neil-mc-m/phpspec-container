<?php

namespace App;

class ConcreteClass implements ConcreteClassInterface
{
    private $serviceProvider;

    public function __construct(ServiceProviderInterface $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function sayHi()
    {
        print 'Hi';
    }
}
