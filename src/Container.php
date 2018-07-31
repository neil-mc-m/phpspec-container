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

        $reflection = new ReflectionClass($classPath);

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $classPath;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies);
        $reflectedClass = $reflection->newInstanceArgs($instances);

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
        $resolvedDependencies = array();

        foreach ($dependencies as $dependency) {

            $class = $dependency->getClass();

            if ($class === null) {
                return;
            }

            $resolvedDependencies[] = $this->get($class->getName());
        }
       
        return $resolvedDependencies;
    }

    /**
     * @param ServiceProviderInterface
     * @param string $id
     * @return static
     */
    public function register($id, ServiceProviderInterface $serviceProvider)
    {
       $this->instances[$id] = $serviceProvider->register();
       return $this;
    }
}
