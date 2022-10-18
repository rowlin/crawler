<?php

namespace App\MessageHandler;

use App\Message\TelegramNotification;
use App\Repository\JobsRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class TelegramNotificationHandler implements MessageHandlerInterface
{

    public function __construct(JobsRepository $jobsRepository)
    {}


    public function __invoke(TelegramNotification $message)
    {
       $result = file_get_contents("https://api.telegram.org/bot" . $message->getToken()."/sendMessage?" . http_build_query($message->getData() ,'','&') );
       $res = json_decode($result);
       /*if($res['ok']){

       }*/
    }
}
