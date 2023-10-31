<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="document_new", methods={"GET","POST"})
     * @param Client $client
     */
    public function new(Request $request, Client $client): Response
    {
        $document = new Document();
        $document->setClient($client);
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$document->getClient()->getId(),
            ]);
        }

        return $this->renderForm('document/modal_add.html.twig', [
            'document' => $document,
            'form' => $form,
            'client'=>$client,
        ]);
    }

    /**
     * @Route("/{id}", name="document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document/edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit_document", name="document_edit_modal", methods={"GET","POST"})
     */
    public function editmodal(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //
            //dd($form);
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$document->getClient()->getId(),
            ]);
        }

        return $this->renderForm('document/modal_edit.html.twig', [
            'document' => $document,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"POST"})
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete'.$document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('document_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/{id}/documentarchive", name="documentarchive", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Document $document
     */
    public function archiveDocument(Request $request, Document $document)
    {
        $document->setDetetedAt(new \DateTime());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$document->getClient()->getId(),
        ]);
    }

    /**
     * @Route ("/{id}/documentresore", name="documentresore", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Document $document
     */
    public function resoreDocument(Request $request, Document $document)
    {
        $document->setDetetedAt(null);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$document->getClient()->getId(),
        ]);
    }

}
