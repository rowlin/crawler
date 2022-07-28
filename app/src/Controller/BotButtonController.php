<?php


namespace App\Controller;


use App\Service\BotButtonService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class BotButtonController extends AbstractController
{

    public function __construct(private BotButtonService $buttonService){
    }

    #[OA\Tag(name: 'bot')]
    #[Route('/api/bot_button/{id}' , methods : 'DELETE' , name:'delete_bot_button')]
    public function delete(int $id) : Response{
        return $this->json($this->buttonService->delete($id));
    }

}
