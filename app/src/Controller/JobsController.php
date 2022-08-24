<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Events\Events;
use App\Events\JobEvent;
use App\Message\RunJob;
use App\Requests\JobCreateRequest;
use App\Requests\JobUpdateRequest;
use App\Service\JobsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class JobsController extends AbstractController
{

    public function __construct(private JobsService $jobsService ,
                                private EventDispatcherInterface $dispatcher ,
                                private MessageBusInterface $bus)
    {
    }

    #[OA\Tag(name: 'job')]
    #[OA\PathParameter(name:'active', in: 'query' , description: 'Available return active/unactive jobs')]
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
        if($this->jobsService->getCurrentJob($id)) {
            $jobEvent = new JobEvent();
            $jobEvent->setJob($id);
            $this->dispatcher->dispatch($jobEvent , Events::RUN_JOB);
            $msg = ['message' => 'ok'];
        }else{
            $msg = ['message' => "Job not found"];
        }
        return $this->json(array_merge( $msg , [ 'data' => $this->jobsService->getJobs()]));
    }

    #[OA\Tag(name: 'job')]
    #[Route('/api/job/run2/{id}' , methods: ['PUT'] , name: 'job_run2')]
    public function run2(int $id) : Response
    {
        if($this->jobsService->getCurrentJob($id)) {
            $jobEvent = new RunJob($id);
            $this->bus->dispatch($jobEvent);
            $msg = ['message' => 'ok'];
        }else{
            $msg = ['message' => "Job not found"];
        }
        return $this->json(array_merge( $msg , [ 'data' => $this->jobsService->getJobs()]));
    }



    #[OA\Tag(name: 'job')]
    #[Route('/api/job/{id}' , methods: ['PATCH'] , name: 'job_update')]
    public function update(#[RequestBody] JobUpdateRequest $request , int $id) : Response
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
