<?php

namespace App\Message;

final class TelegramNotification
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

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
