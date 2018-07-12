<?php

namespace App;

class Container
{

    private $instances = array();

    public function has($key)
    {
        if (in_array($this->instances[$key], $this->instances)) {
            return true;
        }
        return false;
    }

    public function set($key, $class)
    {
        $this->instances[$key] = $class;

        return true;
    }

    public function get($key)
    {
        if ($this->has($key)) {
            $class = $this->instances[$key];
            $newInstance = new $class;

            return $newInstance;
        }
        return 'Class not found';
    }
}
