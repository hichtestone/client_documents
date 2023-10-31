<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Equipement;
use App\Form\Equipement1Type;
use App\Form\EquipementType;
use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipement")
 */
class EquipementController extends AbstractController
{
    /**
     * @Route("/", name="equipement_index", methods={"GET"})
     */
    public function index(EquipementRepository $equipementRepository): Response
    {
        return $this->render('equipement/index.html.twig', [
            'equipements' => $equipementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="equipement_new", methods={"GET","POST"})
     * @param Client $client
     */
    public function new(Request $request, Client $client): Response
    {
        $equipement = new Equipement();
        $equipement->setClient($client);
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           // dd($equipement);
            $equipement->setPassword($equipement->encrypt($equipement->getPassword()));
           // dd($equipement);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$client->getId(),
            ]);
        }

        return $this->renderForm('equipement/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
            'client'=>$client,
        ]);
    }

    /**
     * @Route("/{id}", name="equipement_show", methods={"GET"})
     */
    public function show(Equipement $equipement): Response
    {
        return $this->render('equipement/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="equipement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipement $equipement): Response
    {
        $form = $this->createForm(Equipement1Type::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipement/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="equipement_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipement $equipement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipement_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/{id}/equipementarchive", name="equipementarchive", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Equipement $equipement
     */
    public function archiveDocument(Request $request, Equipement $equipement)
    {
        $equipement->setDeletedAt(new \DateTime());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$equipement->getClient()->getId(),
        ]);
    }

    /**
     * @Route ("/{id}/equipementresore", name="equipementresore", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Equipement $equipement
     */
    public function resoreDocument(Request $request, Equipement $equipement)
    {
        $equipement->setDeletedAt(null);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$equipement->getClient()->getId(),
        ]);
    }

    /**
     * @Route("/{id}/equipement", name="addequipementimport", methods={"GET", "POST"}, requirements={"id":"\d+"})
     * @param Client $client
     */
    public  function importEquipement(Client $client, Request $request)
    {
        $id=$client->getId();
        //  dd($id);
        return $this->render('equipement/import.html.twig',[
            'id'=>$id,
        ]);
    }

    /**
     * @Route("/{id}/insertequipement", name="insertequipement", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public  function insertEquipement(Client $client, Request $request)
    {

        $file=$request->files->get("file");
        if (!is_null($file) && !is_null($file->getClientOriginalName()) && $file->getClientOriginalName() != ""){
            $pieces = explode(".", $file->getClientOriginalName());
            $res = $this->uploadFile($file);
            $fileFolder = $res->getpath() . '/';
            $filePathName = $res->getfilename();
            $fileinfra="../public/uploads/DB/Equipement/".$filePathName;
            //dd($fileinfra);
            if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {
                for ($i=1;$i<count($xlsxi->rows()) ;$i++){
                    $r=$xlsxi->rows()[$i];
                    $equipement=new Equipement();
                    $equipement->setClient($client);
                    if($r[0]!="")
                    $equipement->setTYPE($r[0]);
                    if($r[1]!="")
                        $equipement->setName($r[1]);
                    if($r[2]!="")
                    $equipement->setPassword($equipement->encrypt($r[2]));

                    $manager=$this->getDoctrine()->getManager();
                    $manager->persist($equipement);
                    $manager->flush();

                }
            }else{
                      dd('equipement ' .$fileinfra. " ".\SimpleXLSX::parseError());

            }


        }else {
            $this->addFlash('file', "Désolé, le fichier invalide !!");

        }


        return $this->redirectToRoute("client_show",[
            'id'=>$client->getId(),
        ]);
    }

    function uploadFile($file)
    {
        $fileFolder = __DIR__ . '/../../public/uploads/DB/Equipement';
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        try {
            $res = $file->move($fileFolder, $filePathName);

        } catch (FileException $e) {
        }
        return $res;
    }
}
