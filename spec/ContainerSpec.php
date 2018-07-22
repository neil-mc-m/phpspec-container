<?php

namespace spec\App;

use App\Container;
use PhpSpec\ObjectBehavior;
use App\Val;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use App\Exception\InvalidIdentifierException;
use App\ServiceProviderInterface;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_should_implement_the_psr11_ContainerInterface()
    {
        $this->shouldImplement(ContainerInterface::class);
    }

    function it_can_set_values_on_the_container(ServiceProviderInterface $serviceProvider)
    {
        $this->set('ExampleServiceProvider', $serviceProvider)->shouldReturn(true);
    }

    function it_should_always_return_a_bool_from_the_has_method()
    {
        $this->callOnWrappedObject('has', array('string'))->shouldBeBool();
    }

    function it_can_check_if_classes_are_set(ServiceProviderInterface $serviceProvider)
    {
        $this->set('ExampleId', $serviceProvider);
        $this->has('ExampleId')->shouldReturn(true);
        $this->has('newObject')->shouldReturn(false);
    }

    function it_can_initialize_objects_from_the_container(ServiceProviderInterface $serviceProvider)
    {
        $this->set('ExampleObject', $serviceProvider);
        $this->get('ExampleObject')->shouldReturnAnInstanceOf(ServiceProviderInterface::class);
    }

    function it_should_throw_a_NotFoundException_if_no_entry_is_found()
    {
        $this->shouldThrow(NotFoundExceptionInterface::class)->duringGet('id');
    }

    function it_should_throw_an_InvalidIdentifierException_if_the_identifier_is_not_a_string_or_is_an_empty_string()
    {
        $this->shouldThrow(InvalidIdentifierException::class)->duringSet(array('id'), 'className');
        $this->shouldThrow(InvalidIdentifierException::class)->duringSet(1, 'ClassPath');
        $this->shouldThrow(InvalidIdentifierException::class)->duringSet('', 'ClassPath');
    }
}