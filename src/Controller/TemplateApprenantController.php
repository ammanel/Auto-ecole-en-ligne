<?php

namespace App\Controller;

use App\Entity\AutoEcole;
use App\Entity\Cours;
use App\Entity\Message;
use App\Entity\Transaction;
use App\Form\MessageType;
use App\Form\TransactionType;
use App\Repository\ApprenantRepository;
use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\CoursRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use App\Repository\QuestionRepository;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use function PHPUnit\Framework\isEmpty;

class TemplateApprenantController extends AbstractController
{

    private $requestStack;
    private $params;

    public function __construct(RequestStack $requestStack, ParameterBagInterface $params)
    {
        $this->requestStack = $requestStack;
        $this->params=$params;
    }

    

    
    #[Route('/template/apprenant', name: 'app_template_apprenant')]
    public function index(UserInterface $user, ApprenantRepository $ar): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        if($connecter->getStatut() == false)
        {
            return $this->render("authentification/NonValide.html.twig");;
        }else{
            return $this->render('template_apprenant/index.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
            ]);
        }
        
    }


    
    #[Route('/template/apprenant/liste/cours', name: 'app_liste_cours')]
    public function listeCours(ManagerRegistry $doctrine,Request $request,UserInterface $user,CoursRepository $coursRepository,ApprenantRepository $ar,TransactionRepository $transactionRepository): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        if($connecter->isCoursActive() == false)
        {
                $transaction=new Transaction();
                $form = $this->createForm(TransactionType::class, $transaction);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) { 
                    $em=$doctrine->getManager();
                    $transaction->setIdApprenant($connecter);
                    $transaction->setTypeDePayement("Cours");
                    $transaction->setCours(1);
                    $connecter->setCoursActive(1);
                    $em->persist($transaction);
                    $em->flush();
                    
                }

                return $this->render('template_apprenant/cours.html.twig', [
                    'controller_name' => 'TemplateApprenantController',
                    "user"=> $user,'cours' => $coursRepository->findAll(),'form' => $form->createView()
                ]);
               
                
        }
            
        else{

        
            return $this->render('template_apprenant/cours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cours' => $coursRepository->findAll()
            ]);
        }
        
    }

    #[Route('/template/apprenant/details/{id}/cours', name: 'app_detail_cours')]
    public function detailCours(UserInterface $user,Cours $cours,CoursRepository $coursRepository): Response
    {
         $user->getUserIdentifier();
         $courspecifique=$coursRepository->find($cours);
       
            return $this->render('template_apprenant/detailCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cour' => $courspecifique,
            ]);
        
        
    }

    #[Route('/template/apprenant/question/{id}/cours', name: 'app_question_cours')]
    public function questionCours(UserInterface $user,Cours $cours,QuestionRepository $questionRepository,ManagerRegistry $doctrine): Response
    {
         $user->getUserIdentifier();
         $em=$doctrine->getManager();
        
        $resultQuestion= $questionRepository->findBy(["coursDedie"=>$cours->getId()]);
       
 
            return $this->render('template_apprenant/questionCours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cour' => $cours,
                "qestion"=>$resultQuestion,
             
                
            ]);
        
        
    }

    #[Route('/template/apprenant/liste/auto/ecole', name: 'app_liste_Auto_Ecole')]
    public function listeAutoEcole(Request $request, UserInterface $user,AutoEcoleRepository $autoEcoleRepository, ChoisirRepository $choixrepository,PersonneRepository $personneRepository, MessageRepository $messageRepository): Response
    {
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $arrayautoecole = $choixrepository->findBy(array("idApprenant" => $idConnecter));
        $autoecoleId = $arrayautoecole[0]->getIdEcole();

        $autoecole = $autoEcoleRepository->findBy(array("id"=>$autoecoleId));
        
        //Creation d'une session
        $message = new Message();
        
        $form = $this->createForm(MessageType::class, $message);

        print_r($_REQUEST);
        
        $form->handleRequest($request);
        $message->setContenu("AharhFodio");
        
            if (isEmpty($_REQUEST)){
            
        }else{
            $message->setContenu($_REQUEST["Contenu"]);
            $message->setEnvoyerPar($personneRepository->find($idConnecter));
            $message->setRecuPar($personneRepository->find($autoecoleId));
            $messageRepository->add($message,true);
            
            return $this->redirectToRoute('app_liste_Auto_Ecole');
        }

        
        
        
        $session = $this->requestStack->getSession();
        $session->set("idautoecole", $autoecole[0]->getId() );
        $session->set('autoecole', $autoecole[0]->getDescription() );

        $webpath=$this->params->get("kernel.project_dir").'/src/Controller';
         return $this->render('template_apprenant/listeAutoEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll(),
                "autoecole"=> $session->get("autoecole"),
                "envoyerpar"=>$idConnecter,
                "recupar"=>$autoecoleId,
                "form" => $form->createView()
            ]);
        
        
    }
    #[Route('/template/apprenant/profile/{contenu}/auto/EnvoiMessage', name: 'envoimessage')]
    public function Message(Request $request, UserInterface $user,AutoEcoleRepository $autoEcoleRepository, ChoisirRepository $choixrepository,PersonneRepository $personneRepository, MessageRepository $messageRepository): Response{
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $arrayautoecole = $choixrepository->findBy(array("idApprenant" => $idConnecter));
        $autoecoleId = $arrayautoecole[0]->getIdEcole();

        $autoecole = $autoEcoleRepository->findBy(array("id"=>$autoecoleId));
        
        //Creation d'une session
        $message = new Message();
        
        return $this->redirectToRoute("app_liste_Auto_Ecole");
    }



    #[Route('/template/apprenant/profile/{id}/auto/ecole', name: 'app_profil_Auto_Ecole')]
    public function profilAutoEcole(UserInterface $user,AutoEcole $autoEcole): Response
    {
        
       
         return $this->render('template_apprenant/profil_auto_ecoles.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'autoecole'=>$autoEcole
            ]);
        
        
    }


    #[Route('/template/apprenant/mon/auto/ecole', name: 'app_mon_Auto_Ecole')]
    public function monAutoEcole(UserInterface $user): Response
    {
        
       
         return $this->render('template_apprenant/monEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user
            ]);
        
        
    }

  

}
