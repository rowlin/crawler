<?php


namespace App\Service;


use App\Entity\Bot;
use App\Exception\NotFoundException;
use App\Repository\BotRepository;
use App\Requests\BotCreateRequest;

class BotService
{

    public function __construct(private BotRepository $botRepository ){
    }

    public function getBots(){
        return  $this->botRepository->findAll();
    }

    public function create(BotCreateRequest $request) : array{
        $bot = new Bot();
        $bot->setToken($request->getToken());
        $bot->setName($request->getName());
        $bot->setActive($request->getActive());
        $this->botRepository->add($bot , true);
        return ['message' => "Bot was added"];
    }

    public function delete($id): array{
        $current_bot =  $this->botRepository->findOneBy(['id' => $id]);
        if(!$current_bot)
            throw new NotFoundException("Bot not found");
        else
            $this->botRepository->remove($current_bot , true);
        return ['message' => "Bot was deleted" , 'data' => $this->getBots()];
    }

    public function update(BotCreateRequest $request , $id): array{
        $current_bot =  $this->botRepository->findOneBy(['id' => $id]);
        if(!$current_bot)
            throw new NotFoundException("Bot not found");
        else
            $current_bot->setName($request->getName());
            $current_bot->setToken($request->getToken());
            $current_bot->setActive($request->getActive());
            $this->botRepository->add($current_bot , true);
        return ['message' => "Job updated" , 'data' => $this->getBots()];
    }

}
