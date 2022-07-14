<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Requests\JobCreateRequest;
use App\Service\JobsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use Symfony\Component\HttpFoundation\Response;
class JobsController extends AbstractController
{

    public function __construct(private JobsService $jobsService)
    {
    }

    #[OA\Tag(name: 'job')]
    #[OA\PathParameter(name:'active', in: 'query' , description: 'Available return active/unbactive jobs')]
    #[OA\Response(response: 200 , description: 'Return jobs')]
    #[Route('/api/jobs', methods: ['GET'] , name: 'jobs')]
    public function index(Request $request) : Response
    {
        return $this->json($this->jobsService->getJobs($request));
    }

    #[OA\Tag(name: 'job')]
    #[OA\Parameter( name:"active", required: false)]
    #[OA\Parameter( name:'name', required: true)]
    #[OA\Parameter( name:'url', required: true)]
    #[Route('/api/job/create', methods: ['POST'] , name: 'job_create')]
    public  function create(#[RequestBody] JobCreateRequest $request) : Response
    {
        return $this->json($this->jobsService->createJob($request));
    }


    #[OA\Tag(name: 'job')]
    #[Route('/api/job/run/{id}' , methods: ['PUT'] , name: 'job_run')]
    public function run(int $id) : Response
    {
        return  $this->json($this->jobsService->runJob($id));
    }


    #[OA\Tag(name: 'job')]
    #[Route('/api/job/{id}' , methods: ['PATCH'] , name: 'job_update')]
    public function update(#[RequestBody] JobCreateRequest $request , int $id) : Response
    {
        return $this->json($this->jobsService->updateJob($request , $id));
    }


    #[OA\Tag(name: 'job')]
    #[Route('/api/job/{id}' , methods: ['DELETE'] , name: 'job_delete')]
    public function delete(int $id) : Response
    {
        return $this->json($this->jobsService->deleteJob($id));
    }

}
