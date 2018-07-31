<?php

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;

class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        return new EventDispatcher();
    }

}