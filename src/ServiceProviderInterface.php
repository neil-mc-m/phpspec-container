<?php

namespace App;


interface ServiceProviderInterface
{
    public function register(Container $c);
}