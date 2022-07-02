<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Requests\JobCreateRequest;
use App\Service\JobsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
class JobsController extends AbstractController
{

    public function __construct(private JobsService $jobsService)
    {
    }

    #[Route('/api/jobs', methods: ['GET'] , name: 'jobs')]
    public function index() : Response
    {
        return $this->json($this->jobsService->getJobs());
    }

    #[Route('/api/job/create', methods: ['POST'] , name: 'job_create')]
    public  function create(#[RequestBody] JobCreateRequest $request) : Response
    {
        return $this->json($this->jobsService->createJob($request));
    }

    #[Route('/api/job/run/{id}' , methods: ['PUT'] , name: 'run_job')]
    public function run($id) : Response
    {
        return  $this->json($this->jobsService->runJob($id));
    }

    #[Route('/api/job/{id}' , methods: ['PATCH'] , name: 'job_update')]
    public function update(#[RequestBody] JobCreateRequest $request , $id) : Response
    {
        return $this->json($this->jobsService->updateJob($request , $id));
    }

    #[Route('/api/job/{id}' , methods: ['DELETE'] , name: 'job_delete')]
    public function delete($id) : Response
    {
        return $this->json($this->jobsService->deleteJob($id));
    }

}
