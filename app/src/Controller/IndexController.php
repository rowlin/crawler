<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Rompetomp\InertiaBundle\Service\InertiaInterface;

class IndexController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('page/main.html.twig');
    }


    /**
     * @Route("/", name="app_index")
     */
    public function main(InertiaInterface $inertia)
    {
        return $inertia->render('IndexPage' , ['prop' => 'dataValue']);
    }



}
