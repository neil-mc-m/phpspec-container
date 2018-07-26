<?php

namespace App;

class ConcreteClass implements ConcreteClassInterface
{
    private $serviceProvider;

    public function __construct(ServiceProviderInterface $serviceProvider, CacheProvider $cache)
    {
        $this->serviceProvider = $serviceProvider;
        $this->cache = $cache;
    }

    public function sayHi()
    {
        print 'Hi';
    }
}
