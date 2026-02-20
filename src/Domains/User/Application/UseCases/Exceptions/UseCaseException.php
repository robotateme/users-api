<?php

namespace Domains\User\Application\UseCases\Exceptions;

use Exception;

class UseCaseException extends Exception
{
    public $message = 'Something went wrong';
}
