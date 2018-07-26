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
    public $parameters = array();

    /** @var array */
    private $instances = array();

    /** @var array */
    private $dependencies = array();

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
        // var_dump($instances);
        $reflectedClass = $reflection->newInstanceArgs($instances);

        return $reflectedClass;

    }

    /**
     * @param array $params
     * @return self
     */

    public function setParameters(array $params)
    {
        $this->parameters = $params;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasParameters()
    {
        return isset($this->parameters);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }


    /**
     * @param array $dependencies
     * @return array
     * @throws EntryNotFoundException
     * @throws \ReflectionException
     */
    public function resolveDependencies(array $dependencies)
    {
        foreach ($dependencies as $dependency) {

            $this->parameters[] = $dependency->getClass();

        }
        var_dump($this->parameters);
       
       
        
        var_dump($this->dependencies);
        return $this->dependencies;
    }
}
