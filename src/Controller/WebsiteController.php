<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Post;
use App\Entity\Voir;
use App\Repository\AutoEcoleRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class WebsiteController extends AbstractController
{
    #[Route('', name: 'app_website')]
    public function index(PostRepository $postRepository,AutoEcoleRepository $autoEcoleRepository): Response
    {  
        return $this->render('website/index.html.twig', [
            'controller_name' => 'WebsiteController',
            'posts' => $postRepository->findAll(),
            'autoecole'=>$autoEcoleRepository->findAll()
            
        ]);
    }

    #[Route('/apropos/website', name: 'app_apropos')]
    public function apropos(): Response
    {  
        $apprenant=new Apprenant();
        return $this->render('website/apropos.html.twig', [
            'controller_name' => 'WebsiteController',"apprenant"=>$apprenant
            
        ]);
    }

    
    #[Route('/blog/liste/website', name: 'app_blog_liste')]
    public function blogListe(PostRepository $postRepository): Response
    {  
        $apprenant=new Apprenant();
        return $this->render('website/blog.html.twig', [
            'controller_name' => 'WebsiteController',"apprenant"=>$apprenant,
            'posts' => $postRepository->findAll()            
        ]);
    }

    #[Route('/blog/detail/{id}/website', name: 'app_blog_detail')]
    public function blogDetail(Post $post,UserInterface $user,EntityManagerInterface $em): Response
    {  
        
        $idpost=$post->getId();
        $idper=$user->getUserIdentifier();
        $post->addDatev($user);
        $vue=new Voir();
        $vue->setPostId($idpost);
        $vue->setApprenantId($idper);
        $vue->setDatevisualisation(new \DateTime("now"));
        $em->persist($vue);
        $em->flush($vue);
        
        
        return $this->render('website/blog_detail.html.twig', [
            'controller_name' => 'WebsiteController',
            'post' => $post           
        ]);
    }


    #[Route('/contact/liste/website', name: 'app_contact')]
    public function contact(): Response
    {  
        
        return $this->render('website/contact.html.twig', [
            'controller_name' => 'WebsiteController'
            
        ]);
    }

    #[Route('/ecole/liste/website', name: 'app_liste_ecole_site')]
    public function liste_ecole_siteweb(AutoEcoleRepository $autoEcoleRepository): Response
    {  
        
        return $this->render('website/ecole.html.twig', [
            'controller_name' => 'WebsiteController',
            'autoEcoles'=>$autoEcoleRepository->findAll()

            
        ]);
    }

   
}
