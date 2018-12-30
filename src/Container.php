<?php

namespace App;

use App\Exception\EntryNotFoundException;
use App\Exception\IdentifierAlreadyExistsException;
use App\Exception\InvalidIdentifierException;
use Closure;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /** @var array */
    private $instances = array();

    /**
     * @return static
     */
    public static function make()
    {
        return new static();
    }

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
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            $message = sprintf('An entry wasnt found with that id : %s', $id);

            throw new EntryNotFoundException($message);
        }

        $classPath = $this->instances[$id];

        if ($classPath instanceof Closure) {
            return call_user_func($classPath);
        }

        return new $classPath;

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
