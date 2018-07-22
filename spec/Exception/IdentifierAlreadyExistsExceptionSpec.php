<?php

namespace spec\App\Exception;

use App\Exception\IdentifierAlreadyExistsException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Container\ContainerExceptionInterface;

class IdentifierAlreadyExistsExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IdentifierAlreadyExistsException::class);
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
