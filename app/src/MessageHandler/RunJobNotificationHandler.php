<?php


namespace App\MessageHandler;

use App\Events\Events;
use App\Events\JobEvent;
use App\Message\RunJob;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class RunJobNotificationHandler implements MessageHandlerInterface
{

    public function __construct(private EventDispatcherInterface $dispatcher)
    {}

    public function __invoke(RunJob $job)
    {
        // do something with your message
        $job_event =  new JobEvent();
        $job_event->setJob($job->getJob());
        $this->dispatcher->dispatch($job_event , Events::RUN_JOB);
    }

}
