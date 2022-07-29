<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\AutoEcole;
use App\Form\AdminType;
use App\Form\AutoEcoleType;
use App\Repository\AutoEcoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class TemplateSuperAdminController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
    }

    
    #[Route('/template/super/admin', name: 'app_template_super_admin')]
    public function index(): Response
    {
        return $this->render('template_super_admin/index.html.twig', [
            'controller_name' => 'TemplateSuperAdminController',
        ]);
    }


    #[Route('/template/super/admin/formulaire/admin', name: 'app_template_super_admin_formulaireAdmin')]
    public function formulaireAdmin(Request $request,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash): Response
    {
        $admin = new Admin();
        $form =$this->createForm(AdminType::class,$admin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   

            $conf = $_POST['Confirmation'];
            if($conf != $admin->getPassword())
            {
                return $this->render('template_super_admin/formulaireAdmin.html.twig', [
                    'erreur'=>"Les mots de passes doivent être identiques",
                    "form"=> $form->createView()
                ]);
            }
            $this->addFlash('notice','Inscription Effectuée');
            $admin->setRoles(["ROLE_SUPER_ADMIN"]);
            $admin->setSex($_POST["Sex"]);
            $admin->setStatut(true);
            $hashdePassword=$passwordhash->hashPassword($admin,$admin->getpassword());
            $admin->setpassword($hashdePassword);
            $em->persist($admin);
            $em->flush($admin);
            return $this->redirectToRoute("app_template_super_admin");
        }
        return $this->render('template_super_admin/formulaireAdmin.html.twig', [
            
            "form"=> $form->createView()
        ]);
    }

    #[Route('/template/super/admin/formulaire/auto/ecole', name: 'app_template_super_admin_formulaireAutoEcole')]
    public function formulaireAutoEcole(Request $request,AutoEcoleRepository $ar,EntityManagerInterface $em,UserPasswordHasherInterface $passwordhash): Response
    {
        $autoecole = new AutoEcole();
        $form =$this->createForm(AutoEcoleType::class,$autoecole);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hashdePassword=$passwordhash->hashPassword($autoecole,$autoecole->getpassword());
            $autoecole->setpassword($hashdePassword);
            $autoecole->setRoles(["ROLE_AutoEcole"]);
            $webpath=$this->params->get("kernel.project_dir").'/public/AdminResponsable/img/ImageAutoEcole/';
            $chemin=$webpath.$_FILES['auto_ecole']["name"]["image"];
            $destination=move_uploaded_file($_FILES['auto_ecole']['tmp_name']['image'],$chemin);
            $autoecole->setimage($_FILES['auto_ecole']['name']['image']);
            $autoecole->setHoraireDebut($_POST["HeureDebut"]);
            $autoecole->setHoraireFin($_POST["HeureFin"]);
            $autoecole->setStatut(1);
            $ar->add($autoecole);
            return $this->redirectToRoute('app_template_super_admin', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('template_super_admin/formulaireAuto-ecole.html .twig', [
            'controller_name' => 'TemplateSuperAdminController',
            'form' => $form->createView()
        ]);
    }
}
