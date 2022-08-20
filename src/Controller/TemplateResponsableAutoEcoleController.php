<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Entity\Message;
use App\Entity\Personne;
use App\Entity\Rapport;
use App\Form\MessageType;
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
        $arraypersonne = $personneRepository->findBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne[0]->getId();
        $choix = $choisirRepository->findBy(array("idEcole"=>$idConnecter));

        return $this->render("template_responsable_auto_ecole/liste_apprenant.html.twig",
        ["apprenant" => $choix]
    );
    }


    

    #[Route('/template/responsable/auto/ecole/message_apprenant/{id}/ecole', name: 'message_apprenant', methods: ['GET', 'POST'])]
    public function message_apprenant(Personne $personne,Request $request,Apprenant $apprenant,ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {
        
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        
        if (isset($_REQUEST['contenu']) && $_REQUEST['contenu'] != "") {
            

           
            
            # code...
            $message->setContenu($_REQUEST["contenu"]);
            $message->setEnvoyerPar( $personneRepository->find($_REQUEST["idconnecter"]));
            $message->setRecuPar($personneRepository->find($_REQUEST["idrecupar"]));
            $message->setDateEnvoi(new \DateTime('now'));
            $messageRepository->add($message,true);

            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);

        }
        $arraypersonne = $personneRepository->findOneBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne->getId();
        $choix = $choisirRepository->findBy(array("idEcole"=>$idConnecter));
        $messages = $messageRepository->findBy(array("EnvoyerPar"=>$apprenant->getId()));
        //Creation d'une session


        return $this->render("template_responsable_auto_ecole/message.html.twig",
        ["apprenant" => $apprenant,
        "messages" => $messages,
        "user"=>$user,
        "form"=>$form->createView()
        ]
    );
    }

    #[Route('/template/responsable/auto/ecole/message_apprenant/ecole/message', name: 'message_apprenant_async')]
    public function message_async(Request $request,ChoisirRepository $choisirRepository,UserInterface $user,AutoEcoleRepository $autoEcoleRepository,PersonneRepository $personneRepository,MessageRepository $messageRepository): Response
    {   
        $arraypersonne = $personneRepository->findOneBy(array("Telephone" => $user->getUserIdentifier()));
        $idConnecter = $arraypersonne->getId();
        $message = new Message();




        if ($_REQUEST["contenu"] == "uvbsuvbsiudbvdjksbvjkbsvcjkxbkjvbxjkcbvkjvbdfsvkvjbskjdbvsjkbvsjkdvb skcv kjs dvjskvksjvbkjsdbvkjsbvjksd") {
            # code...
            $mess = $messageRepository->findAll();
            $ar = array();
            for ($i=0; $i < count($mess); $i++) { 
                //$ar("$mess[$i]->getId()" => $mess[$i]->getContenu())
                $ar[$i] = array("contenu" => $mess[$i]->getContenu(),"recupar"=>$mess[$i]->getRecuPar()->getId(),"envoyerpar"=>$mess[$i]->getEnvoyerPar()->getId());
            }
            return $this->json($ar);
        }





        else {
            $choix = $choisirRepository->findBy(array("idApprenant"=>$idConnecter,"satut"=>true));

        $auto = new AutoEcole();
        try {
            //code...
            $auto = $autoEcoleRepository->find($choix[0]->getIdEcole());
        } catch (\Throwable $th) {
            //throw $th;
            $auto->setDescription("");
            
        }
            
            # code...
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
            return $this->json($ar);
        }
        
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
