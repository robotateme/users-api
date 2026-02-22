<?php

namespace Application\UseCases\Exceptions;

class NicknameAlreadyExists extends ApplicationException
{
    public function __construct($message = 'User with nickname: %s already exists!', public string $nickname = '')
    {
        parent::__construct(sprintf($message, $nickname));
    }

}
