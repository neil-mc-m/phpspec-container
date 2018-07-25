<?php

namespace App;

class ConcreteClass implements ConcreteClassInterface
{

    private $email;

    private $address;

    public function __construct($string, $string2)
    {
        $this->email = $string;
        $this->address = $string2;
    }

    public function sayHi()
    {
        print 'Hi';
    }
}