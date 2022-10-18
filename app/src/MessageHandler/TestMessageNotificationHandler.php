<?php

namespace App\MessageHandler;

use App\Message\TestMessage;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class TestMessageNotificationHandler implements MessageHandlerInterface , LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __invoke(TestMessage $message)
    {
        $this->logger->alert("Oops:");

       print_r($message);
    }


}
