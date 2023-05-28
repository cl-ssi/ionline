<?php

namespace App\Exceptions;

use Exception;

class ExceptionSignService extends Exception
{
    public function __construct(string $message = 'Error', int $code = 0)
    {
        parent::__construct($message, $code);
    }
}