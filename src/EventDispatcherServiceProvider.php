<?php

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Container;

class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    public function register(Container $c)
    {
    	$callable = function() { 
    		return new EventDispatcher(); 
    	};
        $c->set('EventDispatcher', $callable);
    }

}