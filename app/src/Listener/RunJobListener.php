<?php

namespace App\Listener;

use App\Entity\Jobs;
use App\Entity\SentResponse;
use App\Events\Events;
use App\Events\JobEvent;
use App\Events\MessageEvent;
use App\Jobs\Runner;
use App\Repository\JobResponseRepository;
use App\Repository\SentResponseRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RunJobListener
{

    public function __construct(private JobResponseRepository $jobResponseRepository,
                                private SentResponseRepository $sentResponseRepository,
                                private EventDispatcherInterface $dispatcher)
    {
    }



    private function checkOrSaveSent( Jobs $current_job , array $res ) : bool{
        $result = false;
        $has = $this->sentResponseRepository->findOneBy(['name' => $res['url']]);

        if(empty($has)){
            $sent_response  = new SentResponse();
            $sent_response->setJobId($current_job);
            $sent_response->setName($res['url']);
            $this->sentResponseRepository->add($sent_response, true);
            $result =  true;
        }
        return $result;
    }

    public function onRunJob(JobEvent $event){
        $current_job = $this->jobResponseRepository->getCurrentJob($event->getJob());
        $runner = new Runner();
        $result = $runner->run($current_job);
        if($result) {
            $this->jobResponseRepository->add($result, true);
            $this->jobResponseRepository->removeIfMore($current_job);
            if($current_job->getChannel() !== null) {
                foreach ( json_decode($result->getResult(), true) as $res) {
                    if($this->checkOrSaveSent($current_job, $res)) {
                        $messageEvent = new MessageEvent();
                        $messageEvent->setJobId($current_job->getId());
                        $messageEvent->setNotify($current_job->getChannel());
                        $messageEvent->setMessage($res);
                        $this->dispatcher->dispatch($messageEvent , Events::PUSH_MESSAGE );
                    }
                }
            }
        }
    }

}
