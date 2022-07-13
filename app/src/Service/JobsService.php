<?php
namespace  App\Service;

use App\Entity\Jobs;
use App\Events\Events;
use App\Events\MessageEvent;
use App\Exception\NotFoundException;
use App\Jobs\Runner;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobResponseRepository;
use App\Repository\JobsRepository;
use App\Requests\JobCreateRequest;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;


class JobsService
{
    public function __construct(private JobsRepository $jobsRepository,
                                private JobResponseRepository $jobResponseRepository,
                                private EventDispatcherInterface $dispatcher){
    }

    protected function map(Jobs $jobs) : JobsListItem{
            return new JobsListItem(
                $jobs->getId(),
                $jobs->getName(),
                $jobs->getUrl(),
                $jobs->getCode(),
                $jobs->getCron(),
                $jobs->getChannel(),
                $jobs->isActive(),
                $jobs->getJob(20)->getValues(),
            );
   }

    public function getJobs(Request $request = null) : JobsListResponse{
        $active = true;
        if(is_object($request) && $request->query->has('active'))
            $active = (bool) filter_var($request->query->get('active'), FILTER_VALIDATE_BOOLEAN);
       $jobs = $this->jobsRepository->getAll($active);
       $items = array_map( [ $this ,'map']  , $jobs);
       return  new JobsListResponse($items);
    }

    public function createJob(JobCreateRequest  $request) : array {
        $job = new Jobs();
        $job->setUrl($request->getUrl());
        $job->setName($request->getName());
        $job->setCode($request->getCode());
        $job->setCron($request->getCron());
        $job->setActive($request->getActive());
        $this->jobsRepository->add($job , true);
        return ['message' => "Job created" , 'data' => $this->getJobs()];
    }

    public function runJob(int $id ) : array{
        $current_job = $this->jobsRepository->findOneBy(['id' => $id]);

        if(!$current_job){
            throw new NotFoundException();
        }else {
            $runner = new Runner();
            $result = $runner->run($current_job);
            if($result) {
                $this->jobResponseRepository->add($result, true);
                $messageEvent = new MessageEvent();
                $messageEvent->setMessage($result->getResult());
                $messageEvent->setNotify($current_job->getChannel());
                //$messageEvent->setNotify();
                $this->dispatcher->dispatch($messageEvent, Events::PUSH_MESSAGE);
            }
        }

        return ['message' => "Job was run" , 'data' => $this->getJobs() ];
    }

    public function updateJob(JobCreateRequest  $request,  int $id ) : array {
        $current_job  = $this->jobsRepository->findOneBy(['id' => $id]);
        $current_job->setName($request->getName());
        $current_job->setUrl($request->getUrl());
        $current_job->setActive($request->getActive());
        $current_job->setCode($request->getCode());
        $current_job->setCron($request->getCron());
        $res = null;
        if( isset($request->getChannel()['bot_id']) & !empty($request->getChannel()['bot_id'])) {
            $res = $this->jobsRepository->addBotChannel($request->getChannel()['bot_id'] , $request->getChannel()['channel_id'] );
        }
        $current_job->setChannel($res);

        $this->jobsRepository->add($current_job , true);

        return ['message' => "Job updated" , 'data' => $this->getJobs()];
    }

    public function deleteJob( int $id) : array{
        $current_job  = $this->jobsRepository->findOneBy(['id' => $id]);
        if($current_job)
            $this->jobsRepository->remove($current_job , true);
        else
            throw new NotFoundException();
        return ['message' => "Job deleted" , 'data' => $this->getJobs() ];
    }


}
