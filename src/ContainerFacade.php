<?php

namespace App;

use ReflectionClass;

class ContainerFacade
{
    private $container;

    public function __construct(Container $c)
    {
        $this->container = $c;
    }

    public function registerInstance($value, $classPath)
    {
        $this->container->set($value, $classPath);

        return $this;
    }

    public function withParameters(array $params)
    {
        $this->container->setParams($params);

        return $this;
    }

    public function getInstance($id)
    {
        $class = $this->container->get($id);

        if ($this->container->hasParameters()) {

            $reflection = new ReflectionClass($class);

            $reflectedClass = $reflection->newInstanceArgs($this->container->getParameters());

            return $reflectedClass;
        }

        return new $class;
    }
}
