<?php

namespace App\Controller;

use App\Repository\SentResponseRepository;
use App\Service\SentResponsesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class SentResponseController extends AbstractController
{

    public function __construct( private SentResponsesService $sentResponsesService )
    {
    }

    #[OA\Tag(name: 'sentResposes')]
    #[OA\PathParameter(name : 'id' , in:'path' , required: true,  description: 'Job id')]
    #[Route('/api/responses/{id}' , methods: 'GET' , name: 'api_get_responses')]
    public function getResponses(int $id) : Response{
        return  $this->json($this->sentResponsesService->getSentResponses($id));
    }


    #[OA\Tag(name: 'sentResposes')]
    #[OA\PathParameter(name : 'id' , in:'path' , required: true,  description: 'SentResposes id')]
    #[Route('/api/responses/{id}' , methods: 'DELETE' , name: 'api_delete_response')]
    public function deleteResponse(int $id) : Response{
        return  $this->json($this->sentResponsesService->deleteSentResponses($id));
    }


}
