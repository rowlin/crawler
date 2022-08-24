<?php


namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class JobEvent extends Event
{
    private int $job;

    public function setJob(int $job): void
    {
        $this->job = $job;
    }

    public function getJob(): int
    {
        return $this->job;
    }


}
