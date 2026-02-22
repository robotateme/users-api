<?php

namespace Application\UseCases\Exceptions;

use Exception;

class ApplicationException extends Exception
{
    public $message = 'Something went wrong';
}
