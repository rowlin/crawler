<?php

namespace App\Controller;

use App\Service\BotService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class TelegramController extends AbstractController
{

    public function __construct(private BotService $botService )
    {
    }

    #[OA\Tag(name: 'webhook')]
    #[OA\PathParameter(name:'token', in: 'path' , description: 'Telegram token')]
    #[Route('/bot{token}/webhook', methods:['POST'], name: 'app_telegram_update')]
    public function update(string $token , Request $request  ): Response
    {
        return  $this->json($this->botService->getUpdate($token , $request));
    }


    #[OA\Tag(name: 'webhook')]
    #[OA\PathParameter(name:'token', in: 'path' , description: 'Telegram token')]
    #[OA\PathParameter(name:'status', in: 'path' , description: 'status [update]')]
    #[Route('/bot{token}/{status}', methods:['GET'], name: 'app_telegram_manual_update')]
    public function manualUpdate( string $token , string $status) : Response
    {
        return $this->json($this->botService->actionWithManualUpdate($token , $status));
    }

}
