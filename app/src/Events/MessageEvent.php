<?php


namespace App\Events;


use Symfony\Contracts\EventDispatcher\Event;

class MessageEvent extends Event
{

    private string $message;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    public function setMessage($message): void
    {
        $this->message = $message;
    }





}
