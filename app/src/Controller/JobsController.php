<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
class JobsController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index() : Response
    {
        return $this->render('page/main.html.twig');
    }
}
