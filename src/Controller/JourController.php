<?php

namespace App\Controller;

use App\Entity\Jour;
use App\Form\JourType;
use App\Repository\JourRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jour')]
class JourController extends AbstractController
{
    #[Route('/liste_jour', name: 'app_jour_index', methods: ['GET'])]
    public function index(JourRepository $jourRepository): Response
    {
        return $this->render('jour/index.html.twig', [
            'jours' => $jourRepository->findAll(),
        ]);
    }

    #[Route('/new/ajouter_jour', name: 'app_jour_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JourRepository $jourRepository): Response
    {
        $jour = new Jour();
        $form = $this->createForm(JourType::class, $jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jourRepository->add($jour, true);

            return $this->redirectToRoute('app_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jour/new.html.twig', [
            'jour' => $jour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/swhow_jour', name: 'app_jour_show', methods: ['GET'])]
    public function show(Jour $jour): Response
    {
        return $this->render('jour/show.html.twig', [
            'jour' => $jour,
        ]);
    }

    #[Route('/{id}/edit_jour', name: 'app_jour_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jour $jour, JourRepository $jourRepository): Response
    {
        $form = $this->createForm(JourType::class, $jour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jourRepository->add($jour, true);

            return $this->redirectToRoute('app_jour_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('jour/edit.html.twig', [
            'jour' => $jour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jour_delete', methods: ['POST'])]
    public function delete(ManagerRegistry $doctrine,Jour $jour): Response
    {
        $em=$doctrine->getManager();
        $jour->setEnable(true);
        $em->flush();
        return $this->redirectToRoute('app_jour_index', [], Response::HTTP_SEE_OTHER);
    }
}
