<?php

namespace App\Controller;

use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\RDVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class RdvAutoecoleController extends AbstractController
{
    #[Route('/rdv/autoecole', name: 'app_rdv_autoecole')]
    public function index(RDVRepository $rDVRepository,ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository): Response
    {
        
        $a = $user->getUserIdentifier();
        $connecter = $autoEcoleRepository->findOneBy(array("Telephone"=>$a));
        $result_inscription=$choisirRepository->findByApprenant($connecter);
        $rdv=$rDVRepository->findBy(["choix"=>$result_inscription]);
        
    
        return $this->render('rdv_autoecole/index.html.twig', [
            'controller_name' => 'RdvAutoecoleController',
            "rdvliste"=>$rdv
        ]);
    }
}
