<?php

namespace App\Exception;

use Psr\Container\ContainerExceptionInterface;

class IdentifierAlreadyExistsException extends \Exception implements ContainerExceptionInterface
{
}
