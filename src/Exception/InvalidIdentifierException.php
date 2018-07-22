<?php

namespace App\Exception;

use Psr\Container\ContainerExceptionInterface;
use Exception;

class InvalidIdentifierException extends Exception implements ContainerExceptionInterface
{
}
