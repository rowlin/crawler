<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Model\BotListResponse;
use App\Requests\BotCreateRequest;
use App\Requests\BotUpdateRequest;
use App\Service\BotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class BotController extends AbstractController
{

    public function __construct(private BotService $botService)
    {
    }

    #[OA\Tag(name: 'bot')]
    #[Route('/api/bot', methods:['GET'], name: 'app_bot')]
    public function index() : Response{
        return $this->json($this->botService->getBots()->getItems());
    }

    #[OA\Tag(name: 'bot')]
    #[Route('/api/bot/create', methods:['POST'] , name: 'bot_create' )]
    public function create(#[RequestBody] BotCreateRequest $request): Response{
        return  $this->json($this->botService->create($request));
    }

    #[OA\Tag(name: 'bot')]
    #[Route('/api/bot/{id}' , methods: ['PATCH'] , name : 'bot_update')]
    public function update(#[RequestBody] BotUpdateRequest $request , int $id) : Response {
        return  $this->json($this->botService->update($request , $id));
    }

    #[OA\Tag(name: 'bot')]
    #[Route('/api/bot/{id}' , methods: ['DELETE'] , name : 'bot_delete')]
    public function delete(int $id) : Response {
        return  $this->json($this->botService->delete($id));
    }

}
