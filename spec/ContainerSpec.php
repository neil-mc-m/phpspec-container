<?php

namespace spec\App;

use App\Container;
use PhpSpec\ObjectBehavior;
use App\Val;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_can_set_values_on_the_container()
    {
        $this->set('val', Val::class)->shouldReturn(true);
    }

    function it_can_check_if_classes_are_set()
    {
        $this->set('val', Val::class);
        $this->has('val')->shouldReturn(true);
    }


    function it_can_initialize_objects_from_the_container()
    {
        $this->set('val', Val::class);
        $this->get('val')->shouldReturnAnInstanceOf(Val::class);
    }
}
