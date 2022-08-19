<?php

namespace App\Controller;

use App\Entity\AutoEcole;
use App\Entity\Rapport;
use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use DateTime;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Date;

class TemplateResponsableAutoEcoleController extends AbstractController
{

    private $requestStack; 
    private $params;

    public function __construct(RequestStack $requestStack, ParameterBagInterface $params)
    {
        $this->requestStack = $requestStack;
        $this->params=$params;
    }

    #[Route('/template/responsable/auto/ecole', name: 'app_template_responsable_auto_ecole')]
    public function index(ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {


        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $messages = $messageRepository->find($idConnecter);
        $choix = $choisirRepository->findAll();
        return $this->render('template_responsable_auto_ecole/index.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
            "choix"=> $choix,
            "messages"=> $messages,
            "idapprenant"=>2

        ]);
    }

    #[Route('/template/responsable/auto/ecole/message_choix_apprenant', name: 'message_choix_apprenant')]
    public function message_choix_apprenant(ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {
        return $this->render("template_responsable_auto_ecole/liste_apprenant.html.twig");
    }

    #[Route('/template/responsable/auto/ecole/payement', name: 'app_payement_stat')]
    public function payemnt_menu(): Response
    {
        return $this->render('template_responsable_auto_ecole/payement.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',
        ]);
    }

    #[Route('/template/responsable/auto/ecole/rapport', name: 'app_rapport',methods:['POST','GET'])]
    public function raport(Request $request,ManagerRegistry $doctrine): Response
    {    
        $user = $this->getUser();
        $rapport=$request->request->get('contenu_rapport');

        $EntiteRapport=new Rapport();
        $EntiteRapport->setContenu(strval($rapport));
        $EntiteRapport->setCreateur($user);
        $EntiteRapport->setDateCrea(new \DateTime('now'));
        $EntiteRapport->setTimeCrea(new \DateTime('now'));
        $em=$doctrine->getManager();
        $em->persist($EntiteRapport);
        $em->flush();
        

        return $this->render('template_responsable_auto_ecole/rapport.html.twig', [
           
        ]);
    }

    #[Route('/template/responsable/auto/ecole/{id}/profil', name: 'app_template_responsable_auto_ecole_profil')]
    public function profilEcole(UserInterface $user): Response
    {

        return $this->render('template_responsable_auto_ecole/profil_auto_ecole.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',"user"=>$user
        ]);
    }


    #[Route('/template/responsable/auto/ecole/{id}/paramètre/compte', name: 'app_template_responsable_auto_ecole_parametre')]
    public function parametres(UserInterface $user): Response
    {

        return $this->render('template_responsable_auto_ecole/parametres.html.twig', [
            'controller_name' => 'TemplateResponsableAutoEcoleController',"user"=>$user
        ]);
    }
}
