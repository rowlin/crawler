<?php

namespace App\Controller;

use App\Attribute\RequestBody;
use App\Requests\TemplateRequest;
use App\Service\TemplateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;


class TemplatesController extends AbstractController
{


    public function __construct(private TemplateService $templateService)
    {

    }

    #[OA\Tag(name: 'Templates')]
    #[OA\Response(response: 200 , description: "Get all Templates" )]
    #[Route('/api/templates', methods:['GET'], name: 'get_templates')]
    public function index(): Response
    {
        return  $this->json($this->templateService->getAll());
    }


    #[OA\Tag(name: 'Templates')]
    #[OA\Response(response: 200 , description: "Create a Template" )]
    #[OA\Response(response: 400 , description: "Failed validation" )]
    #[OA\Response(response: 404 , description: "Not found" )]
    #[OA\Parameter(name: 'code', required: true , schema: new OA\Schema(type: 'text' )  )]
    #[OA\Parameter(name: 'name', required: true , schema: new OA\Schema(type: 'string' )  )]
    #[Route('/api/templates', methods:['POST'], name: 'create_new_template')]
    public function create(#[RequestBody] TemplateRequest $data): Response
    {
        return  $this->json($this->templateService->create($data));
    }




    #[OA\Tag(name: 'Templates')]
    #[OA\Response(response: 200 , description: "Template deleted" )]
    #[OA\Response(response: 404 , description: "Not found" )]
    #[OA\PathParameter( name : 'id' , required: true )]
    #[Route('/api/template/{id}', methods:['DELETE'], name: 'delete_template')]
    public function delete(int $id) : Response
    {
        return  $this->json($this->templateService->delete($id));
    }



    #[OA\Tag(name: 'Templates')]
    #[OA\Response(response: 200 , description: "Template deleted" )]
    #[OA\Response(response: 400 , description: "Failed validation" )]
    #[OA\Response(response: 404 , description: "Not found" )]
    #[OA\PathParameter( name : 'id' , required: true )]
    #[OA\Parameter(name: 'name', required: true , schema: new OA\Schema(type: 'string' )  )]
    #[OA\Parameter(name: 'code', required: true , schema: new OA\Schema(type: 'text' )  )]
    #[Route('/api/template/{id}', methods:['PATCH'], name: 'edit_template')]
    public function edit(#[RequestBody] TemplateRequest $data ,int $id ): Response
    {
        return  $this->json($this->templateService->edit($id  , $data));
    }


}
