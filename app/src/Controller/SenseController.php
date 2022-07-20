<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Requests\SenseRequest;
use App\Service\SenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class SenseController extends AbstractController
{

    public function __construct( private SenseService $senseService )
    {
    }



    #[OA\Tag(name: 'sense')]
    #[OA\PathParameter(name : 'id' , in:'path' , required: true,  description: 'Job id')]
    #[Route('/api/sense/{id}', methods: ['PUT'] ,name: 'add_sense')]
    public function add(#[RequestBody] SenseRequest $request ,  int $id ) : Response{
        return  $this->json($this->senseService->add( $request , $id));
    }



    #[OA\Tag(name: 'sense')]
    #[OA\PathParameter(name : 'id' , in:'path' , required: true,  description: 'Sense id')]
    #[Route('/api/sense/{id}', methods: ['DELETE'] ,name: 'delete_sense')]
    public function delete( int $id) : Response{
        return  $this->json($this->senseService->delete($id));
    }


    #[OA\Tag(name: 'sense')]
    #[OA\PathParameter(name : 'id' , in:'path' , required: true,  description: 'Sense id')]
    #[OA\Parameter(name : "sense" , required: true , description: 'sense')]
    #[Route('/api/sense/{id}', methods: ['POST'] ,name: 'update0_sense')]
    public function update(#[RequestBody]  SenseRequest $request, int $id ){
        return $this->json($this->senseService->update( $id,  $request));
    }

}
