<?php
namespace  App\Service;

use App\Entity\Jobs;
use App\Exception\NotFoundException;
use App\Jobs\Runner;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobResponseRepository;
use App\Repository\JobsRepository;
use App\Requests\JobCreateRequest;
use Symfony\Component\HttpFoundation\Request;


class JobsService
{
    public function __construct(private JobsRepository $jobsRepository , private JobResponseRepository $jobResponseRepository){
    }

    protected function map(Jobs $jobs) : JobsListItem{
            return new JobsListItem(
                $jobs->getId(),
                $jobs->getName(),
                $jobs->getUrl(),
                $jobs->getCode(),
                $jobs->getCron(),
                $jobs->isNotify(),
                $jobs->getChannel(),
                $jobs->isActive(),
                $jobs->getJob(20)->getValues()
            );
   }

    public function getJobs(Request $request = null) : JobsListResponse{
        $active = true;
        if($request->query->has('active'))
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
        $job->setNotify($request->isNotify());
        $job->setChannel(null);
        $this->jobsRepository->add($job , true);
        return ['message' => "Job created" , 'data' => $this->getJobs()];
    }

    public function runJob(int $id) : array{
        $current_job = $this->jobsRepository->findOneBy(['id' => $id]);
        if(!$current_job){
            throw new NotFoundException();
        }else {
            $runner = new Runner();
            $result = $runner->run($current_job);
            $this->jobResponseRepository->add($result, true);
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
