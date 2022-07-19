<?php


namespace App\Events;


use App\Entity\BotChannel;
use Symfony\Contracts\EventDispatcher\Event;

class MessageEvent extends Event
{

    private array $message;

    private BotChannel $notify;

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

        return  $this;
    }





}
