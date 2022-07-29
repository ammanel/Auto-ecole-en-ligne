<?php

namespace App\Controller;

use App\Entity\TypeDocument;
use App\Form\TypeDocumentType;
use App\Repository\TypeDocumentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/document')]
class TypeDocumentController extends AbstractController
{
    #[Route('/', name: 'app_type_document_index', methods: ['GET'])]
    public function index(TypeDocumentRepository $typeDocumentRepository): Response
    {
        return $this->render('type_document/index.html.twig', [
            'type_documents' => $typeDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeDocumentRepository $typeDocumentRepository): Response
    {
        $typeDocument = new TypeDocument();
        $form = $this->createForm(TypeDocumentType::class, $typeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeDocumentRepository->add($typeDocument, true);

            return $this->redirectToRoute('app_type_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_document/new.html.twig', [
            'type_document' => $typeDocument,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_type_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeDocument $typeDocument, TypeDocumentRepository $typeDocumentRepository): Response
    {
        $form = $this->createForm(TypeDocumentType::class, $typeDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeDocumentRepository->add($typeDocument, true);

            return $this->redirectToRoute('app_type_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_document/edit.html.twig', [
            'type_document' => $typeDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_document_delete')]
    public function delete(ManagerRegistry $doctrine, TypeDocument $typeDocument, TypeDocumentRepository $typeDocumentRepository): Response
    {
        $em=$doctrine->getManager();
        $typeDocument->setEnable(true);
        $em->flush();
       
        return $this->redirectToRoute('app_type_document_index');
    }
}
