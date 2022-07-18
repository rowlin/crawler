<?php


namespace App\Service;


use App\Events\Events;
use App\Events\MessageEvent;
use App\Jobs\Runner;
use App\Repository\JobResponseRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class JobRunnerService
{
    public function __construct(private JobResponseRepository $jobResponseRepository,
                                private EventDispatcherInterface $dispatcher)
    {
    }


    public function runJob(int $id ) : array{
        $current_job = $this->jobResponseRepository->getCurrentJob($id);
        $runner = new Runner();
        $result = $runner->run($current_job);
        if($result) {
            $this->jobResponseRepository->add($result, true);
            $this->jobResponseRepository->removeIfMore($current_job->getMaxCount() - 1);
            if($current_job->getChannel() !== null) {
                $messageEvent = new MessageEvent();
                $messageEvent->setMessage($result->getResult());
                $this->dispatcher->dispatch($messageEvent, Events::PUSH_MESSAGE);
            }
        }

        return ['message' => "Job was run" ];
    }


}
