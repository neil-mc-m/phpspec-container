<?php

namespace App;

use Closure;

interface ServiceProviderInterface
{
    /**
     * @param Container $c
     * @return Closure
     */
    public function register(Container $c);
}