<?php

namespace App\Exception;

use Psr\Container\NotFoundExceptionInterface;
use Exception;

class EntryNotFoundException extends Exception implements NotFoundExceptionInterface
{
}
