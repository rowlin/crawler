<?php

namespace App\MessageHandler;

use App\Message\TelegramNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class TelegramNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(TelegramNotification $message)
    {
        // do something with your message

        file_get_contents("https://api.telegram.org/bot" . $message->getToken()."/sendMessage?" . http_build_query($message->getData() ,'','&') );
    }
}
