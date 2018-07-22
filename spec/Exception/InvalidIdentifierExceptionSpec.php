<?php

namespace spec\App\Exception;

use App\Exception\InvalidIdentifierException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Container\ContainerExceptionInterface;

class InvalidIdentifierExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidIdentifierException::class);
    }

    function it_should_implement_the_psr11_ContainerExceptionInterface()
    {
        $this->shouldImplement(ContainerExceptionInterface::class);
    }

    function it_should_extend_the_Exception_class()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
