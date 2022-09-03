<?php

namespace App\Message;


final class RunJob
{


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
