<?php

namespace App;


interface ServiceProviderInterface
{

    /**
     * @param Container $c
     * @return Closure
     */
    public function register(Container $c);
}