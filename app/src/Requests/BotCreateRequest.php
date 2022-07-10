<?php


namespace App\Requests;


use Symfony\Component\Validator\Constraints\NotBlank;

class BotCreateRequest
{

    #[NotBlank]
    private string $name;

    #[NotBlank]
    private string $token;

    #[NotBlank]
    private mixed $active;

    private bool $is_webhook;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getActive(): mixed
    {
        return $this->active;
    }

    public function setActive(mixed $active): void
    {
        $this->active = $active;
    }

    public function getIsWebhook(): bool
    {
        return $this->is_webhook;
    }

    public function setIsWebhook(bool $is_webhook): void
    {
        $this->is_webhook = $is_webhook;
    }

}
