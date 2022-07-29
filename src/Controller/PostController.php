<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/poste')]
class PostController extends AbstractController
{

    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params=$params;
        
    }
    
    
    #[Route('/postindex', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $webpath=$this->params->get("kernel.project_dir").'/public/Post/';
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $chemin=$webpath.$_FILES['post']["name"]["image"];
            $destination=move_uploaded_file($_FILES['post']['tmp_name']['image'],$chemin);
            $post->setImage($_FILES['post']['name']['image']);
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $webpath=$this->params->get("kernel.project_dir").'/public/Post/';

        if ($form->isSubmitted() && $form->isValid()) {
            $chemin=$webpath.$_FILES['post']["name"]["image"];
            $destination=move_uploaded_file($_FILES['post']['tmp_name']['image'],$chemin);
            $post->setImage($_FILES['post']['name']['image']);
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete')]
    public function delete(ManagerRegistry $doctrine, Post $post): Response
    {
        $em=$doctrine->getManager();
        $post->setEnable(true);
        $em->flush();

        return $this->redirectToRoute('app_post_index');
    }
}
