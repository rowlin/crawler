<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Requests\ChannelCreateRequest;
use App\Service\ChannelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;


class ChannelController extends AbstractController
{

    public function __construct(private ChannelService $channelService)
    {
    }

    #[OA\Tag(name: 'channel')]
    #[OA\Response(response: 200 , description: "Return channel List")]
    #[Route('/api/channels', methods:['GET'], name: 'app_channel')]
    public function index(): Response
    {
        return $this->json($this->channelService->getChannels());
    }

    #[OA\Tag(name: 'channel')]
    #[OA\Response(response: 200 , description: "Create new channel" )]
    #[OA\Response(response: 400 , description: "Failed validation" )]
    #[OA\Parameter(name: 'name', required: true , schema: new OA\Schema(type: 'string' , maxLength: 100 )  )]
    #[OA\Parameter(name: 'chat_id', required: true , schema: new OA\Schema(type: 'string' , maxLength: 100 )  )]
    #[Route('/api/channel/create', methods: ['POST'] , name: 'channel_create' )]
    public function create(#[RequestBody] ChannelCreateRequest $request): Response{
        return $this->json( $this->channelService->create($request));
    }

    #[OA\Tag(name: 'channel')]
    #[OA\Response(response: 200 , description: "Update a channel" )]
    #[OA\Response(response: 400 , description: "Failed validation" )]
    #[OA\Response(response: 404 , description: "Not found" )]
    #[OA\PathParameter(name: 'id', required: true , schema: new OA\Schema(type: 'integer') )]
    #[OA\Parameter(name: 'name', required: true , schema: new OA\Schema(type: 'string' , maxLength: 100 )  )]
    #[OA\Parameter(name: 'chat_id', required: true , schema: new OA\Schema(type: 'string' , maxLength: 100 )  )]
    #[Route('/api/channel/{id}' , methods: ['PATCH'] , name : 'channel_update')]
    public function update(#[RequestBody] ChannelCreateRequest $request , int $id) : Response {
        return  $this->json($this->channelService->update($request , $id));
    }

    #[OA\Tag(name: 'channel')]
    #[OA\PathParameter(name: 'id', required: true , schema: new OA\Schema(type: 'integer') )]
    #[OA\Response(response: 200 , description: "Delete a channel" )]
    #[OA\Response(response: 404 , description: "Not found" )]
    #[Route('/api/channel/{id}' , methods: ['DELETE'] , name : 'channel_delete')]
    public function delete(int $id) : Response {
        return  $this->json($this->channelService->delete($id));
    }

}
