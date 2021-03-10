<?php

namespace App\Exceptions;

class InvalidJsonFileStructure extends \Exception
{
    public $message = 'The given json file has the invalid structure';
}
