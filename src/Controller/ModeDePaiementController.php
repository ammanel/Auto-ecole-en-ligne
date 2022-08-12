<?php

namespace App\Controller;

use App\Entity\ModeDePaiement;
use App\Form\ModeDePaiementType;
use App\Repository\ModeDePaiementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mode/de/paiement')]
class ModeDePaiementController extends AbstractController
{
    #[Route('/', name: 'app_mode_de_paiement_index', methods: ['GET'])]
    public function index(ModeDePaiementRepository $modeDePaiementRepository): Response
    {
        return $this->render('mode_de_paiement/index.html.twig', [
            'mode_de_paiements' => $modeDePaiementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mode_de_paiement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModeDePaiementRepository $modeDePaiementRepository): Response
    {
        $modeDePaiement = new ModeDePaiement();
        $form = $this->createForm(ModeDePaiementType::class, $modeDePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modeDePaiementRepository->add($modeDePaiement, true);

            return $this->redirectToRoute('app_mode_de_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mode_de_paiement/new.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mode_de_paiement_show', methods: ['GET'])]
    public function show(ModeDePaiement $modeDePaiement): Response
    {
        return $this->render('mode_de_paiement/show.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mode_de_paiement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ModeDePaiement $modeDePaiement, ModeDePaiementRepository $modeDePaiementRepository): Response
    {
        $form = $this->createForm(ModeDePaiementType::class, $modeDePaiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modeDePaiementRepository->add($modeDePaiement, true);

            return $this->redirectToRoute('app_mode_de_paiement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mode_de_paiement/edit.html.twig', [
            'mode_de_paiement' => $modeDePaiement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mode_de_paiement_delete')]
    public function delete(ManagerRegistry $doctrine, ModeDePaiement $modeDePaiement): Response
    {
        $em=$doctrine->getManager();
        $modeDePaiement->setEnable(true);
        $em->flush();

        return $this->redirectToRoute('app_mode_de_paiement_index', [], Response::HTTP_SEE_OTHER);
    }
}
