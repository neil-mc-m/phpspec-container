<?php

namespace spec\App;

use App\ConcreteClass;
use App\Container;
use App\ContainerFacade;
use PhpSpec\ObjectBehavior;

class ContainerFacadeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContainerFacade::class);
    }

    function let(Container $c)
    {
        $this->beConstructedWith($c);
    }

    function it_should_be_able_to_set_values_on_the_container(Container $c)
    {
        $this->registerInstance('Concrete', ConcreteClass::class)->shouldReturn($this);
    }

    function it_should_be_able_to_set_parameters_on_an_object()
    {
        $this->withParameters(array('string', 'another string'))->shouldReturn($this);
    }

    function it_should_get_an_instance_from_the_container(Container $c)
    {


        $this->getInstance('Concrete')->shouldReturnAnInstanceOf(ConcreteClass::class);
    }
}
