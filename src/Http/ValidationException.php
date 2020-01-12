<?php

namespace App\Http;

use App\Http\Validator\Errors;

class ValidationException extends \LogicException
{
    private $errors;

    public function __construct(Errors $errors)
    {
        parent::__construct('Validation errors.');
        $this->errors = $errors;
    }

    public function getErrors(): Errors
    {
        return $this->errors;
    }
}
