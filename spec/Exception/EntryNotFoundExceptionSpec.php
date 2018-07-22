<?php

namespace spec\App\Exception;

use App\Exception\EntryNotFoundException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EntryNotFoundException::class);
    }

    function it_should_implement_the_psr11_NotFoundException()
    {
        $this->shouldImplement(NotFoundExceptionInterface::class);
    }

    function it_should_extend_the_Exception_class()
    {
        $this->shouldHaveType(\Exception::class);
    }
}
