<?php


namespace App\Service;


use App\Exception\NotFoundException;
use App\Repository\BotButtonsRepository;

class BotButtonService
{

    public function __construct(private BotButtonsRepository $botButtonsRepository)
    {
    }


    public function delete(int $id): array{
        $button = $this->botButtonsRepository->find(['id' => $id]);
        if(!$button)
            throw new NotFoundException("Button not found");
        $this->botButtonsRepository->remove($button , true);
        return  ['message' => "Button was removed"];
    }


}
