<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Rappel;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use App\Repository\RappelRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/document')]
class DocumentController extends AbstractController
{
    #[Route('/liste', name: 'app_document_index', methods: ['GET'])]
    public function index(DocumentRepository $documentRepository,UserInterface $user): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
            "user"=> $user,
        ]);
    }

    #[Route('/new', name: 'app_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DocumentRepository $documentRepository,UserInterface $user, RappelRepository $rappelRepository): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $document->setCompte($user);
            $recupType=$document->getTypedoc();
            $recupDuree= $recupType->getDuree();
            $recupdate=$document->getDateEtablissement();
           // $dateExpi=date('Y-m-d', strtotime($recupdate.' + 1 days')); 

            $rappel=new Rappel();
            //$rappel->setIdDoc($document->getTypedoc());
            
            
            //Durée à ajouter
            $duree = $recupType->getDuree();

            
            
            $dateFin         = date('Y-m-d', strtotime('+'.$duree.' Year', strtotime($recupdate->format("Y-m-d")) ));


            $dateFin = new DateTime($dateFin);
            //$a = new DateTime($date);
            $rappel->setDateExpiration($dateFin);

            $document->setRappelId($rappel);
            
            
            //$rappel->setDateExpiration(new DateTime($dateExpi));


            $documentRepository->add($document, true);

            //Fonction creer dans le repository
            //$doc = $documentRepository->FindRappel($document,$document->getId(),$recupType);
            

            $rappelRepository->add($rappel,true);

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/new.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_document_show', methods: ['GET'])]
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Document $document, DocumentRepository $documentRepository): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentRepository->add($document, true);

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_document_delete')]
    public function delete(ManagerRegistry $doctrine, Document $document, DocumentRepository $documentRepository): Response
    {
        $em=$doctrine->getManager();
        $document->setEnable(true);
        $em->flush();


        return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
