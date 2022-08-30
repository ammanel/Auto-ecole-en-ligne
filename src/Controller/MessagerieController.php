<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagerieController extends AbstractController
{
    #[Route('/messagerie/apprenant', name: 'app_messagerie_apprenant')]
    public function index(): Response
    {
        return $this->render('messagerie/message.html.twig', [
            'controller_name' => 'MessagerieController',
        ]);
    }
}
