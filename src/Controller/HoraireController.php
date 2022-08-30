<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Entity\Session;
use App\Form\HoraireType;
use App\Repository\HoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/horaire')]
class HoraireController extends AbstractController
{
    #[Route('/liste_horaire', name: 'app_horaire_index', methods: ['GET'])]
    public function index(HoraireRepository $horaireRepository): Response
    {
        return $this->render('horaire/index.html.twig', [
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/planning/{id}', name: 'app_planning', methods: ['GET'])]
    public function planning(HoraireRepository $horaireRepository,Session $session): Response
    {
        return $this->render('horaire/planing.html.twig', [
            'pt' => $horaireRepository->findBySortePlanning($session,'théorique'),
            'pp' => $horaireRepository->findBySortePlanning($session,'pratique'),
        ]);
    }

    #[Route('/planning_part_apprenant/{id}', name: 'app_planning_part_apprenant', methods: ['GET'])]
    public function planning_part_apprenant(HoraireRepository $horaireRepository,Session $session): Response
    {
        return $this->render('horaire/planing_part_apprenant.html.twig', [
            'pt' => $horaireRepository->findBySortePlanning($session,'théorique'),
            'pp' => $horaireRepository->findBySortePlanning($session,'pratique'),
            'session'=>$session
        ]);
    }

    #[Route('/new/ajouter_horaire/pratique/{id}/', name: 'app_horaire_new_pratique', methods: ['GET', 'POST'])]
    public function new_pratique(Request $request, HoraireRepository $horaireRepository,Session $session): Response
    {
        $horaire = new Horaire();
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setSession($session);
            $horaire->setType('pratique');
            $horaireRepository->add($horaire, true);


            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/new.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
          
            'horaires' => $horaireRepository->findAll(),
        ]);
    }

    #[Route('/new/ajouter_horaire/theorique/{id}/', name: 'app_horaire_new_theorique', methods: ['GET', 'POST'])]
    public function new_theorique(Request $request, HoraireRepository $horaireRepository,Session $session): Response
    {
        $horaire = new Horaire();
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);
      

        if ($form->isSubmitted() && $form->isValid()) {
            $horaire->setSession($session);
            $horaire->setType('théorique');
            $horaireRepository->add($horaire, true);


            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/new2.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
            'horaires' => $horaireRepository->findAll(),
        ]);
    }


    #[Route('/{id}/show_horaire', name: 'app_horaire_show', methods: ['GET'])]
    public function show(Horaire $horaire): Response
    {
        return $this->render('horaire/show.html.twig', [
            'horaire' => $horaire,
        ]);
    }

    #[Route('/{id}/edit_horaire', name: 'app_horaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Horaire $horaire, HoraireRepository $horaireRepository): Response
    {
        $form = $this->createForm(HoraireType::class, $horaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $horaireRepository->add($horaire, true);

            return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('horaire/edit.html.twig', [
            'horaire' => $horaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_horaire_delete', methods: ['POST'])]
    public function delete(ManagerRegistry $doctrine, Horaire $horaire): Response
    {
        $em=$doctrine->getManager();
        $horaire->setEnable(true);
        $em->flush();

        return $this->redirectToRoute('app_horaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
