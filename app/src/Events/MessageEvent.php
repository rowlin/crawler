<?php


namespace App\Events;


use App\Entity\BotChannel;
use Symfony\Contracts\EventDispatcher\Event;

class MessageEvent extends Event
{

    private array $message;

    private int $job_id;

    private BotChannel $notify;


    public function getJobId(): int
    {
        return $this->job_id;
    }

    public function setJobId(int $job_id): void
    {
        $this->job_id = $job_id;
    }

    public function getMessage(): array
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getNotify(): BotChannel
    {
        return $this->notify;
    }

    public function setNotify(BotChannel $notify): self
    {
        $this->notify = $notify;

        return $this;
    }


}
