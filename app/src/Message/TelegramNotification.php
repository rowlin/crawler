<?php

namespace App\Message;

final class TelegramNotification
{

     private array $data;

     private string $token;

     public function __construct(string $token , array $data)
     {
         $this->token = $token;
         $this->data = $data;
     }


     public function getToken(): string{
         return $this->token;
     }

    public function getData(): array
    {
        return $this->data;
    }
}
