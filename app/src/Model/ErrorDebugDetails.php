<?php

namespace App\Model;

class ErrorDebugDetails
{
    private $trace;
    public function __construct( string $trace)
    {
        $this->trace = $trace;
    }

    public function getTrace(): string
    {
        return $this->trace;
    }
}
