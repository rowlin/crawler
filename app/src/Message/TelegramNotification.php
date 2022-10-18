<?php

namespace App\Message;

final class TelegramNotification
{

     private array $data;
     private int $job_id ;
     private string $token;

     public function __construct(string $token, int $job_id , array $data)
     {
         $this->job_id = $job_id;
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

    public function getJobId(): int
    {
        return $this->job_id;
    }
}
