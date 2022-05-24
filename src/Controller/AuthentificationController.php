<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Form\ApprenantType;
use App\Form\AutoEcoleType;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthentificationController extends AbstractController
{
    #[Route('', name: 'app_connexion')]
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
        $error=$authenticationUtils->getLastAuthenticationError();
        $LastUsername=$authenticationUtils->getLastUsername();

        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_template_apprenant');
        }
        if ($this->isGranted('ROLE_AutoEcole')) {
            return $this->redirectToRoute('app_template_responsable_auto_ecole');
        }
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirectToRoute('app_template_super_admin');
        }

        return $this->render('authentification/connexion.html.twig', [
            'controller_name' => 'AuthentificationController',
            'error'=>$error,
            'LastUsername'=>$LastUsername
        ]);
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash): Response
    {
        $apprenant = new Apprenant();
        $form =$this->createForm(ApprenantType::class,$apprenant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   

            $conf = $_POST['confirmation'];
            if($conf != $apprenant->getPassword())
            {
                return $this->render('authentification/inscription.html.twig', [
                    'controller_name' => 'AuthentificationController',
                    'erreur'=>"Les mots de passes doivent être identiques",
                    "form"=> $form->createView()
                ]);
            }
            $this->addFlash('notice','Inscription Effectuée');
            $apprenant->setRoles(["ROLE_USER"]);
            $apprenant->setSex($_POST["sex"]);
            $hashdePassword=$passwordhash->hashPassword($apprenant,$apprenant->getpassword());
            $apprenant->setpassword($hashdePassword);
            $em->persist($apprenant);
            $em->flush($apprenant);
            return $this->redirectToRoute("app_connexion");
        }
        return $this->render('authentification/inscription.html.twig', [
            'controller_name' => 'AuthentificationController',
            "form"=> $form->createView()
        ]);
    }

    #[Route('/Deconnexion', name: 'security_logout')]
    public function SecurityLogout(RequestStack $requestStack): Response
    {
        throw new \Exception('Désolée,Déconnexion échouée');
    }
}
