<?php

namespace App\Model;

class ErrorValidationDetailsItem
{
    private $field;
    private $message;

    public function __construct( string $field,  string $message)
    {
        $this->field  = $field;
        $this->message = $message;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
