<?php

namespace App\Exception;

use RuntimeException;

class NotFoundException extends RuntimeException
{
    public function __construct( string $message = 'Job not found' )
    {
        parent::__construct($message);
    }
}
