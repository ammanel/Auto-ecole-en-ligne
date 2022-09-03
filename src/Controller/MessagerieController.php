<?php

namespace App\Controller;

use App\Entity\AutoEcole;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\ApprenantRepository;
use App\Repository\AutoEcoleRepository;
use App\Repository\ChoisirRepository;
use App\Repository\MessageRepository;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class MessagerieController extends AbstractController
{
    #[Route('/messagerie/apprenant', name: 'app_messagerie_apprenant')]
    public function index( Request $request, UserInterface $user,PersonneRepository $personneRepository ,ChoisirRepository $choisirRepository,AutoEcoleRepository $autoEcoleRepository , MessageRepository $messageRepository): Response
    {

        

        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $arrayautoecole = $choisirRepository->findBy(array("idApprenant" => $idConnecter,"satut"=>false));
        try {
            $autoecoleId = $arrayautoecole[0]->getIdEcole();
        } catch (\Throwable $th) {
            $autoecoleId = 0;
        }
        

        $autoecole = $autoEcoleRepository->find($autoecoleId);
        


        

        $allautoecole = $autoEcoleRepository->findAll();
        $choix = $choisirRepository->findBy(array("idApprenant"=>$idConnecter,"satut"=>true));

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

        try {
            //code...
            $form = $this->createForm(MessageType::class, $message);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
       

        
        
        $form->handleRequest($request);
        
        
        if (isset($_REQUEST["contenu"]) && $_REQUEST["contenu"] == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }

            return  $this->json($ar);

        }else{
            
            $messages = $messageRepository->findAll();
            $ecole= $choisirRepository->findByEcole($idConnecter);
            $sessions=[];
            /*
            foreach ($ecole as $val) {
                $sessions=$sessionRepository->findBy(["autoEcole"=>$val->getIdEcole()]);
            }*/
            
            try {
                //code...
                return $this->render('messagerie/message.html.twig', [
                    'controller_name' => 'TemplateApprenantController',
                    "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll(),
                    "autoecole"=> $auto->getDescription(),
                    "autoecoleid"=>"",
                    "envoyerpar"=>$idConnecter,
                    "recupar"=>$auto->getId(),
                    "form" => $form->createView(),
                    "messages"=> $messages,
                    "ecole"=>$ecole,
                    "sessions"=>$sessions
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return $this->render('messagerie/message.html.twig', [
                    'controller_name' => 'TemplateApprenantController',
                    "user"=> $user,"ecoles"=>$autoEcoleRepository->findAll(),
                    //"autoecole"=> $auto->getDescription(),
                    "autoecoleid"=>"",
                    "envoyerpar"=>$idConnecter,
                    //"recupar"=>$auto->getId(),
                    "form" => $form->createView(),
                    "messages"=> $messages,
                    "ecole"=>$ecole,
                    "sessions"=>$sessions
                ]);
            }

            
            
        }
        
    }
    #[Route("/messagerie/apprenant/notifications", "messages_apprenant_notifications")]
    public function NotificationsApprenant(ApprenantRepository $apprenantRepository, MessageRepository $messageRepository): Response
    {
        if (isset($_REQUEST["lu"])) {
            # code...
            $apprenantRepository->UpdateNotifications($_REQUEST["envoyerpar"]);
        }
        
        if (isset($_REQUEST["envoyerpar"])) {
            # code...
            $notifs = $messageRepository->findBy(array("lu"=>false,"RecuPar"=>$_REQUEST["envoyerpar"]));
            $a = count($notifs);
            $array = array("nombre"=>$a);
            return $this->json($array);
        }
    }

    #[Route('/messagerie/listeNotifications', name: 'app_liste_notification_apprenants')]
    public function listeNotifications(ApprenantRepository $apprenantRepository)
    {
        $mess = $apprenantRepository->listeNotifications($_REQUEST["envoyerpar"]);
        
        $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
        return $this->json($ar);
    }

    #[Route("/messagerie/apprenant/messages", "message_envoi_apprenant")]
    public function EnvoiDeMessage( Request $request, UserInterface $user,PersonneRepository $personneRepository ,ChoisirRepository $choisirRepository,AutoEcoleRepository $autoEcoleRepository , MessageRepository $messageRepository): Response
    {
        if (isset($_REQUEST["contenu"]) && $_REQUEST["contenu"] == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }

            return  $this->json($ar);
        }

        
        
        if (isset($_REQUEST['contenu']) && $_REQUEST['contenu'] != "" && $_REQUEST['contenu'] != "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            

           
            $message = new Message();
            # code...
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar( $personneRepository->find($_REQUEST["idconnecter"]));
            $message->setRecuPar($personneRepository->find($_REQUEST["idrecupar"]));
            $message->setDateEnvoi(new \DateTime('now'));
            $message->setLu(false);
            $messageRepository->add($message,true);

            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);

        }elseif ( isset($_REQUEST['contenu']) && $_REQUEST['contenu']  == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }

            return  $this->json($ar);
        }
    }

    
}


