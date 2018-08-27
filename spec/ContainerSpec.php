<?php

namespace spec\App;

use App\ConcreteClass;
use App\Container;
use App\Exception\IdentifierAlreadyExistsException;
use App\Exception\InvalidIdentifierException;
use App\ServiceProviderInterface;
use PhpSpec\ObjectBehavior;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

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

    function it_can_set_values_on_the_container(TestOne $test1)
    {
        $this
            ->set('TestOne', $test1)
            ->shouldReturn(true);
    }

    function it_should_always_return_a_bool_from_the_has_method()
    {
        $this
            ->callOnWrappedObject('has', array('string'))
            ->shouldBeBool();
    }

    function it_can_check_if_classes_are_set(TestOne $test1)
    {
        $this->set('TestOne', $test1);
        $this->has('TestOne')->shouldReturn(true);
        $this->has('Test2')->shouldReturn(false);
    }

    function it_can_initialize_objects_from_the_container(TestOne $test1)
    {
        $this->set('TestOne', $test1);
        $this
            ->get('TestOne')
            ->shouldReturnAnInstanceOf(TestOne::class);
    }

    function it_should_throw_a_NotFoundException_if_no_entry_is_found()
    {
        $this
            ->shouldThrow(NotFoundExceptionInterface::class)
            ->duringGet('id');
    }

    function it_should_throw_an_InvalidIdentifierException_if_the_identifier_is_not_a_string_or_is_an_empty_string()
    {
        $this
            ->shouldThrow(InvalidIdentifierException::class)
            ->duringSet(array('id'), 'className');
        $this
            ->shouldThrow(InvalidIdentifierException::class)
            ->duringSet(1, 'ClassPath');
        $this
            ->shouldThrow(InvalidIdentifierException::class)
            ->duringSet('', 'ClassPath');
    }

    function it_should_throw_an_IdentifierAlreadyExistsException_on_duplicate_keys()
    {
        $this->set('TestOne', TestOne::class);
        $this
            ->shouldThrow(IdentifierAlreadyExistsException::class)
            ->duringSet('TestOne', TestOne::class);
    }

    function it_can_register_a_service_provider_on_the_container()
    {
        $this
            ->register('TestOne', new TestOneServiceProvider())
            ->shouldReturn($this);
    }

    function it_should_return_the_instance_from_the_service_provider()
    {
        $this
            ->register('TestOne', new TestOneServiceProvider())
            ->shouldReturn($this);
        $this
            ->get('TestOne')
            ->shouldReturnAnInstanceOf(TestOne::class);
    }

    function it_should_resolve_classes_that_depend_on_other_classes_in_the_constructor()
    {
        $this->set('TestOne', TestOne::class);
        $this->set('TestTwo', TestTwo::class);
        $this
            ->callOnWrappedObject('get', array('TestTwo'))
            ->shouldReturnAnInstanceOf(TestTwo::class);
    }

    function it_should_resolve_primitive_values_via_the_constructor()
    {
        $this->set('Test3', TestThree::class);
        $this->get('Test3')->shouldReturnAnInstanceOf(TestThree::class);
    }

    function it_should_build_an_object_with_parameters()
    {
        $this->set('TestThree', TestThree::class);
        $this
            ->withArguments(array('neil'))
            ->build('TestThree')
            ->shouldReturnAnInstanceOf(TestThree::class);
    }

}

/**
 * Test Classes.
 */
class TestOne
{
    public function __construct()
    {

    }
}

class TestTwo
{
    public $testone;

    public function __construct(TestOne $testone)
    {
        $this->testone = $testone;

    }
}

class TestThree
{
    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}

class TestOneServiceProvider implements ServiceProviderInterface
{
    public function register(Container $c)
    {
        $callable = function () {
            return new TestOne();
        };
        
        return $callable;
    }
}
