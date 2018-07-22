<?php

namespace App;

use Psr\Container\ContainerInterface;
use App\Exception\EntryNotFoundException;
use App\Exception\InvalidIdentifierException;

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
        $this->instances[$id] = $classPath;

        return true;
    }

    /**
     * @param string $id
     * @return mixed
     * @throws EntryNotFoundException
     */
    public function get($id)
    {
        if ($this->has($id) === false) {
            $message = sprintf('An entry wasnt found with that id : %s', $id);

            throw new EntryNotFoundException($message);
        }

        $classPath = $this->instances[$id];
        $newInstance = new $classPath;

        return $newInstance;
    }
}
