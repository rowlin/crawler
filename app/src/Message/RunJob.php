<?php

namespace App\Message;

use App\Entity\Jobs;

final class RunJob
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

    private $job;

    public function __construct(int $job)
    {
        $this->job = $job;
    }


    public function getJob(): int
    {
        return $this->job;
    }

}
