<?php


namespace App\Model;


class BotListItem
{
    private $id;

    private $name;

    private $token;

    private $active;

    private $is_webhook;

    private $botButtons;


    public function __construct($id , $name  , $token , $active , $is_webhook , $botButtons)
    {
        $this->id  = $id;
        $this->name = $name;
        $this->token = $token;
        $this->active =$active ;
        $this->is_webhook = $is_webhook;
        $this->botButtons = $this->setBotButtons($botButtons);
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }

    public function getIsWebhook()
    {
        return $this->is_webhook;
    }

    public function setIsWebhook($is_webhook): void
    {
        $this->is_webhook = $is_webhook;
    }

    public function getBotButtons()
    {
        return $this->botButtons;
    }

    public function setBotButtons($botButtons): array
    {
        $data  = [];
        foreach ($botButtons as $index => $item) {
            $data[$index] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'callback' => $item->getCallback(),
                'url' => $item->getUrl(),
            ];
        }

        return $data;
    }




}
