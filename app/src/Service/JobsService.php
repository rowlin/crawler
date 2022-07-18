<?php
namespace  App\Service;

use App\Entity\Jobs;
use App\Exception\NotFoundException;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobsRepository;
use App\Requests\JobCreateRequest;
use App\Requests\JobUpdateRequest;
use Symfony\Component\HttpFoundation\Request;

class JobsService
{
    public function __construct(private JobsRepository $jobsRepository){
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
                $jobs->getMaxCount(),
                $jobs->getJob(20)->getValues(),
                $jobs->getSenseBlackLists()->getValues()

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
        $job->setMaxCount(20);
        $this->jobsRepository->add($job , true);
        return ['message' => "Job created" , 'data' => $this->getJobs()];
    }


    public function updateJob(JobUpdateRequest  $request,  int $id ) : array {
        $current_job  = $this->jobsRepository->getCurrentJob($id);
        $current_job->setName($request->getName());
        $current_job->setUrl($request->getUrl());
        $current_job->setActive($request->getActive());
        $current_job->setCode($request->getCode());
        $current_job->setCron($request->getCron());
        $current_job->setMaxCount($request->getMaxCount());
        $res = null;

        if( $current_job->getChannel() === null &
            isset($request->getChannel('bots')['id']) &
            isset($request->getChannel('channels')['id'])
        ) {
            $res = $this->jobsRepository->addBotChannel( (int) $request->getChannel('bots')['id'] , (int) $request->getChannel('channels')['id']);
        }
        $current_job->setChannel($res);

        $this->jobsRepository->add($current_job , true);

        return ['message' => "Job updated" , 'data' => $this->getJobs()];
    }


    public function deleteJob( int $id) : array{
        $current_job  = $this->jobsRepository->getCurrentJob($id);
        if($current_job)
            $this->jobsRepository->remove($current_job , true);
        else
            throw new NotFoundException();
        return ['message' => "Job deleted" , 'data' => $this->getJobs() ];
    }

}
