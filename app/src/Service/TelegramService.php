<?php


namespace App\Service;

use App\Repository\BotChannelRepository;

class TelegramService
{
    public function __construct(private BotChannelRepository $botchannel){ }



}
