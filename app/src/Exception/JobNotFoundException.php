<?php

namespace App\Exception;

use RuntimeException;

class JobNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Job not found');
    }
}
