<?php

namespace App\Controller;

use App\Service\BotService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

class TelegramController extends AbstractController
{

    public function __construct(private BotService $botService )
    {
    }

    #[Route('/bot{token}/webhook', methods:['POST'], name: 'app_telegram_update')]
    public function update(string $token , Request $request  ): Response
    {
        return  $this->json($this->botService->getUpdate($token , $request));
    }

    #[Route('/bot{token}/{status}', methods:['GET'], name: 'app_telegram_manual_update')]
    public function manualUpdate( string $token , string $status) {
        return $this->botService->actionWithManualUpdate($token , $status);
    }



}
