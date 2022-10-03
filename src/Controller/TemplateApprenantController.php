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
use App\Repository\DocumentRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use App\Repository\QuestionRepository;
use App\Repository\RapportRepository;
use App\Repository\SessionRepository;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(DocumentRepository $documentRepository,UserInterface $user, ApprenantRepository $ar,TransactionRepository $transactionRepository): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));
        if($connecter->getStatut() == false)
        {
            return $this->render("authentification/NonValide.html.twig");;
        }else{

            $transaction_pratique=count($transactionRepository->findBy(['typeDePayement'=>'pratique']));
            $transaction_présentiel=count($transactionRepository->findBy(['typeDePayement'=>'présentiel']));
            $transaction_conduite=count($transactionRepository->findBy(['typeDePayement'=>'cours conduite']));
            $nombre_doc=count($documentRepository->findBy(['compte'=>$connecter]));

            

            return $this->render('template_apprenant/index.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
                'pra'=>json_encode($transaction_pratique),
                'pre'=>json_encode($transaction_présentiel),
                'cc'=>json_encode($transaction_conduite),
                'document_repository'=>$nombre_doc

                
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
                    "user"=> $user,'cours' => $coursRepository->findAll(),'form' => $form->createView(),
                    "Nom"=>$connecter->getNom(),
                    "Prenom"=>$connecter->getPrenom(),
                    "Mail"=>$connecter->getMail()

                ]);
               
                
        }
            
        else{

        
            $a = $user->getUserIdentifier();
            $connecter = $ar->findOneBy(array("Telephone"=>$a));
        
            return $this->render('template_apprenant/cours.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,'cours' => $coursRepository->findAll(),
                "Nom"=>$connecter->getNom(),
                "Prenom"=>$connecter->getPrenom(),
                "Mail"=>$connecter->getMail()
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
        $arrayautoecole = $choixrepository->findBy(array("idApprenant" => $idConnecter,"satut"=>false));
        try {
            $autoecoleId = $arrayautoecole[0]->getIdEcole();
        } catch (\Throwable $th) {
            $autoecoleId = 0;
        }
        

        $autoecole = $autoEcoleRepository->find($autoecoleId);
        


        

        $allautoecole = $autoEcoleRepository->findAll();
        $choix = $choixrepository->findBy(array("idApprenant"=>$idConnecter,"satut"=>true));

        $auto = new AutoEcole();
        try {
            //code...
            $auto = $autoEcoleRepository->find($choix[0]->getIdEcole());
        } catch (\Throwable $th) {
            //throw $th;
            $auto->setDescription("");
            
        }

        

       
        //Creation d'une session
        $message = new Message();
        
        $form = $this->createForm(MessageType::class, $message);

        
        
        $form->handleRequest($request);
        
        
        if (isset($_REQUEST['contenu']) && $_REQUEST['contenu'] != "" && $_REQUEST["contenu"] != "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd"){
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar($personneRepository->find($idConnecter));
            $message->setRecuPar($personneRepository->find($auto->getId()));
            $message->setDateEnvoi(new \DateTime('now'));
            $messageRepository->add($message,true);
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            echo "Sa marche";
            return  $this->json($ar);
        }elseif (isset($_REQUEST["contenu"]) && $_REQUEST["contenu"] == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }

            return  $this->json($ar);

        }else{
            
            
        }

        $session = $this->requestStack->getSession();
        

        //$messages = $messageRepository->findAll();
        
        try {
            //code...
            return $this->render('template_apprenant/listeAutoEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll(),
                //"autoecole"=> $auto->getDescription(),
                
                "envoyerpar"=>$idConnecter,
                "recupar"=>$auto->getId(),
                "form" => $form->createView(),
                //"messages"=> $messages
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->render('template_apprenant/listeAutoEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll(),
                //"autoecole"=> $auto->getDescription(),
                "autoecoleid"=>"",
                "envoyerpar"=>$idConnecter,
                //"recupar"=>$auto->getId(),
                "form" => $form->createView(),
                //"messages"=> $messages
            ]);
        }
        
         
        
        
    }
   


    #[Route('/template/apprenant/profile/{id}/auto/ecole', name: 'app_profil_Auto_Ecole')]
    public function profilAutoEcole(AutoEcole $autoEcole,UserInterface $user,ChoisirRepository $choisirRepository,ApprenantRepository $ar,SessionRepository $sessionRepository): Response
    {
        
       
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));    
        $ecole= $choisirRepository->findByEcole($connecter);
        $sessions=[];
        
       
        foreach ($ecole as $val) {
            $sessions=$sessionRepository->findBy(["autoEcole"=>$val->getIdEcole()]);
            
        }
         return $this->render('template_apprenant/profil_auto_ecoles.html.twig', [
                'controller_name' => 'TemplateApprenantController',
               'ecole'=>$autoEcole,
               'sessions'=>$sessions
            ]);
        
        
    }


    #[Route('/template/apprenant/mon/auto/ecole', name: 'app_mon_Auto_Ecole')]
    public function monAutoEcole(PersonneRepository $personneRepository,TransactionRepository $transactionRepository,UserInterface $user,SessionRepository $sessionRepository,ApprenantRepository $ar,ChoisirRepository $choisirRepository): Response
    {
        $a = $user->getUserIdentifier();
        $connecter = $ar->findOneBy(array("Telephone"=>$a));    
        $ecole= $choisirRepository->findByEcole($connecter);
        $sessions=[];
        $auto_ecole=[];
        $expire=0;
       
        foreach ($ecole as $val) {
            $sessions=$sessionRepository->findBy(["autoEcole"=>$val->getIdEcole()]);
            $auto_ecole=$personneRepository->findOneBy(["id"=>$val->getIdEcole()]) ;
        }
        
        $recup_transaction_session=$transactionRepository->findsession($connecter);
        $derniere_transaction= end($recup_transaction_session);
      
        foreach ( $derniere_transaction as $transaction) { 
            $fin_session=$transaction->getidSession()->getDateFin();
            $date_today=new \DateTime('now');
           
                    
            if ($date_today>=$fin_session) {
               $expire=1;
            } else {
               $expire=0;
            }
            # code...
        }
        
        
        
         return $this->render('template_apprenant/monEcole.html.twig', [
                'controller_name' => 'TemplateApprenantController',
                "user"=> $user,
                "ecole"=>$auto_ecole,
                "sessions"=>$sessions,
                "exiparation"=>$expire,
                "typeTransaction"=>$derniere_transaction
            ]);
        
        
    }
   

    #[Route('/tansaction/cours', name: 'app_transaction_cours')]
    public function transaction_cours(): Response
    {  
        
        return $this->render('template_apprenant/transaction.html.twig', [
            'controller_name' => 'WebsiteController'
            
        ]);
    }
  

}
