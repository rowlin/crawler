<?php
namespace  App\Service;

use App\Entity\JobResponse;
use App\Entity\Jobs;
use App\Exception\JobNotFoundException;
use App\Model\JobsListItem;
use App\Model\JobsListResponse;
use App\Repository\JobResponseRepository;
use App\Repository\JobsRepository;
use App\Requests\JobCreateRequest;
use Doctrine\Common\Collections\Criteria;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpClient\HttpClient;


class JobsService
{
    public function __construct(private JobsRepository $jobsRepository,
                                private JobResponseRepository $jobResponseRepository ){
    }

    protected function map(Jobs $jobs) : JobsListItem{
            return new JobsListItem(
                $jobs->getId(),
                $jobs->getName(),
                $jobs->getUrl(),
                $jobs->getCode(),
                $jobs->getStartDate(),
                $jobs->isActive(),
                $jobs->getJob()->getValues()
            );
   }

    public function getJobs() : JobsListResponse{
       $jobs = $this->jobsRepository->findBy([] , ['id' => Criteria::DESC]);
       $items = array_map( [ $this ,'map']  , $jobs);
       return  new JobsListResponse($items);
    }

    public function createJob(JobCreateRequest  $request)  {
        $job = new Jobs();
        $job->setUrl($request->getUrl());
        $job->setName($request->getName());
        $job->setCode($request->getCode());
        $job->setStartDate(null);
        $job->setActive($request->getActive());
        $this->jobsRepository->add($job , true);
        return ['message' => "Job created"];//TODO: fix that
    }

    public function runJob(int $id){
        $current_job = $this->jobsRepository->findOneBy(['id' => $id]);
       $client =  HttpClient::create();

        $response = $client->request('POST', 'http://puppetter:3000/scrape' , [
            'headers' => [
                'Content-Type' => 'text/html',
            ],
            'body' => $current_job->getCode()]);

        $job_response =  new JobResponse();
        $job_response->setCode(  $response->getStatusCode())
             ->setJob(  $current_job)
             ->setResult($response->getContent())
             ->setDate(new \DateTime('@'.strtotime('now')));
        $this->jobResponseRepository->add($job_response , true);

        return "OK";

    }

    public function updateJob(JobCreateRequest  $request,  int $id ) {
        $current_job  = $this->jobsRepository->findOneBy(['id' => $id]);
        $current_job->setName($request->getName());
        $current_job->setUrl($request->getUrl());
        $current_job->setActive($request->getActive());
        $current_job->setCode($request->getCode());
        $this->jobsRepository->add($current_job , true);
    }

    public function deleteJob( int $id){
        $current_job  = $this->jobsRepository->findOneBy(['id' => $id]);
        if($current_job)
            $this->jobsRepository->remove($current_job , true);
        else
            throw new JobNotFoundException();
    }


}
