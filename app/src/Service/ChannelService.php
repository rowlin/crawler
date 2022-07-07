<?php


namespace App\Service;

use App\Entity\Channel;
use App\Exception\NotFoundException;
use App\Repository\ChannelRepository;
use App\Requests\ChannelCreateRequest;

class ChannelService
{

    public function __construct(private ChannelRepository $channelRepository ){
    }

    public function getChannels(){
        return  $this->channelRepository->findAll();
    }

    public function create(ChannelCreateRequest $request) : array{
        $channel = new Channel();
        $channel->setChatId($request->getChatId());
        $channel->setName($request->getName());
        $this->channelRepository->add($channel , true);
        return  ['message' => "Channel added" ];
    }

    public function delete(int $id) : array{
        $current_channel =  $this->channelRepository->findOneBy(['id' => $id]);
        if(!$current_channel)
            throw new NotFoundException("Channel not found");
        else
            $this->channelRepository->remove($current_channel , true);
        return ['message' => "Channel was deleted" , 'data' => $this->getChannels()];
    }


    public function update(ChannelCreateRequest $request , int $id): array{
     $current_channel =  $this->channelRepository->findOneBy(['id' => $id]);
        if(!$current_channel)
            throw new NotFoundException("Channel not found");
        else
            $current_channel->setName($request->getName());
            $current_channel->setChatId($request->getChatId());
            $this->channelRepository->add($current_channel , true);
        return ['message' => "Job updated" , 'data' => $this->getChannels()];
    }

}
