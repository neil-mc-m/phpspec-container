<?php

namespace App;

use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Container;

class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * @param \App\Container $c
     * @return \Closure
     */
    public function register(Container $c)
    {
    	$callable = function() {
    		return new EventDispatcher();
    	};

        return $callable;
    }

}
