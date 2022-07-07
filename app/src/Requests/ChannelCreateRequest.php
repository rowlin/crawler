<?php


namespace App\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;

class ChannelCreateRequest
{

    #[NotBlank]
    private string $name;

    #[NotBlank]
    private string $chat_id;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getChatId(): string
    {
        return $this->chat_id;
    }

    public function setChatId(string $chat_id): void
    {
        $this->chat_id = $chat_id;
    }

}
