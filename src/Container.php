<?php

namespace App;

use App\Exception\EntryNotFoundException;
use App\Exception\IdentifierAlreadyExistsException;
use App\Exception\InvalidIdentifierException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    /** @var array */
    private $instances = array();

    /** @var array */
    private $parameters = array();

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->instances[$id]);
    }

    /**
     * @param string $id
     * @param string $classPath
     * @return bool
     * @throws IdentifierAlreadyExistsException
     * @throws InvalidIdentifierException
     */
    public function set($id, $classPath)
    {
        if (!is_string($id)) {
            throw new InvalidIdentifierException('The identifier must be a string');
        }

        if (strlen($id) < 1) {
            throw new InvalidIdentifierException('The identifier must not be empty');
        }

        if ($this->has($id) === true) {
            $message = sprintf('That identifier already exists : %s', $id);

            throw new IdentifierAlreadyExistsException($message);
        }

        $this->instances[$id] = $classPath;
        
        return true;
    }

    /**
     * @param string $id
     * @return mixed|object
     * @throws EntryNotFoundException
     * @throws \ReflectionException
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            $message = sprintf('An entry wasnt found with that id : %s', $id);

            throw new EntryNotFoundException($message);
        }

        $classPath = $this->instances[$id];

        if (is_callable($classPath)) {
            return call_user_func($classPath);
        }
        $reflection = $this->getReflectedClass($classPath);

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $classPath;
        }

        $dependencies = $constructor->getParameters();

        $resolved = $this->resolveDependencies($dependencies);

        $reflectedClass = $this->createInstance($reflection, $resolved);

        return $reflectedClass;

    }

    /**
     * @param array $dependencies
     * @return array
     * @throws EntryNotFoundException
     * @throws \ReflectionException
     */
    public function resolveDependencies(array $dependencies)
    {
        $resolved = array();

        foreach ($dependencies as $dependency) {

            $class = $dependency->getClass();

            $resolved[] = $class === null
                ? $dependency->getName()
                : $this->get($class->getShortName());
        }
       
        return $resolved;
    }


    /**
     * @param array $parameters
     * @return $this
     */
    public function withArguments(array $parameters)
    {
        foreach ($parameters as $param) {
            $this->parameters[] = $param;
        }

        return $this;

    }

    /**
     * @param string $class
     * @return object
     * @throws \ReflectionException
     */
    public function build($class)
    {
        $classPath = $this->instances[$class];
        $reflectedClass = $this->reflectClass($classPath);

        return $reflectedClass;
    }

    /**
     * @param string $classPath
     * @return object
     * @throws \ReflectionException
     */
    private function reflectClass($classPath)
    {
        $reflection = $this->getReflectedClass($classPath);
        $reflectedClass = $this->createInstance($reflection, $this->parameters);

        return $reflectedClass;
    }

    /**
     * @param $classPath
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    private function getReflectedClass($classPath)
    {
        $reflection = new ReflectionClass($classPath);

        return $reflection;
    }

    /**
     * @param $reflection
     * @param $resolved
     * @return mixed
     */
    private function createInstance($reflection, $resolved)
    {
        $reflectedClass = $reflection->newInstanceArgs($resolved);

        return $reflectedClass;
    }

    /**
     * @param string $id
     * @param ServiceProviderInterface
     * @return static
     */
    public function register($id, ServiceProviderInterface $serviceProvider)
    {
        $callable = $serviceProvider->register($this);
        $this->instances[$id] = $callable;

        return $this;
    }

}
