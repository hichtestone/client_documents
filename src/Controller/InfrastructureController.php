<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Infrastructure;
use App\Form\Infrastructure1Type;
use App\Form\InfrastructureType;
use App\Repository\InfrastructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/infrastructure")
 */
class InfrastructureController extends AbstractController
{
    /**
     * @Route("/", name="infrastructure_index", methods={"GET"})
     */
    public function index(InfrastructureRepository $infrastructureRepository): Response
    {
        return $this->render('infrastructure/index.html.twig', [
            'infrastructures' => $infrastructureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="infrastructure_new", methods={"GET","POST"})
     * @param Client $client
     */
    public function new(Request $request, Client $client): Response
    {
        $infrastructure = new Infrastructure();
        $infrastructure->setClient($client);
     //   dd($infrastructure);
        $form = $this->createForm(InfrastructureType::class, $infrastructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infrastructure);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$client->getId(),
            ]);
        }
        return $this->renderForm('infrastructure/modal_add.html.twig', [
            'infrastructure' => $infrastructure,
            'form' => $form,
            'client'=>$client,
        ]);
    }

    /**
     * @Route("/{id}", name="infrastructure_show", methods={"GET"})
     */
    public function show(Infrastructure $infrastructure): Response
    {
        return $this->render('infrastructure/show.html.twig', [
            'infrastructure' => $infrastructure,
        ]);
    }


    /**
     * @Route("/{id}", name="infrastructure_delete", methods={"POST"})
     */
    public function delete(Request $request, Infrastructure $infrastructure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$infrastructure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($infrastructure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('infrastructure_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/{id}/infrastructurearchive", name="infrastructurearchive", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Infrastructure $infrastructure
     */
    public function archiveDocument(Request $request, Infrastructure $infrastructure)
    {
        $infrastructure->setDeletedAt(new \DateTime());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$infrastructure->getClient()->getId(),
        ]);
    }

    /**
     * @Route ("/{id}/infrastructureresore", name="infrastructureresore", methods={"POST", "GET"}, requirements={"id":"\d+"})
     * @param Infrastructure $infrastructure
     */
    public function resoreDocument(Request $request, Infrastructure $infrastructure)
    {
        $infrastructure->setDeletedAt(null);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute("client_show",[
            'id'=>$infrastructure->getClient()->getId(),
        ]);
    }

    /**
     * @Route("/{id}/infrastructure", name="addinfrastructureimport", methods={"GET", "POST"}, requirements={"id":"\d+"})
     * @param Client $client
     */
    public  function importInfrastructure(Client $client, Request $request)
    {
     $id=$client->getId();
   //  dd($id);
        return $this->render('infrastructure/import.html.twig',[
            'id'=>$id,
        ]);
    }

    /**
     * @Route("/{id}/insertinfrastructure", name="insertInfra", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public  function insertInfrastructure(Client $client, Request $request)
    {

      $file=$request->files->get("file");

        if (!is_null($file) && !is_null($file->getClientOriginalName()) && $file->getClientOriginalName() != ""){
            $pieces = explode(".", $file->getClientOriginalName());
            $res = $this->uploadFile($file);
            $fileFolder = $res->getpath() . '/';
            $filePathName = $res->getfilename();
            $fileinfra="../public/uploads/DB/Infrastructures/".$filePathName;

          //   dd($fileinfra);
       //     dd(\SimpleXLSX::parse($fileinfra));

            if ( $xlsxi = \SimpleXLSX::parse($fileinfra) ) {
//dd('tttt');

                for ($i=1;$i<count($xlsxi->rows()) ;$i++){
                    $r=$xlsxi->rows()[$i];

                    $infrastructure= new Infrastructure();
                    $infrastructure->setClient($client);
                    $infrastructure->setSite($r[0]);

                    if($r[1]!="")
                        $infrastructure->setNomSvr($r[1]);
                    if($r[2]!="")
                        $infrastructure->setOS($r[2]);
                    if($r[3]!="")
                        $infrastructure->setCPUPROC($r[3]);
                    if($r[4]!="")
                        $infrastructure->setRAM($r[4]);
                    if($r[5]!="")
                        $infrastructure->setTotalDisque($r[5]);
                    if($r[6]!="")
                        $infrastructure->setDisqueUsed($r[6]);
                    if($r[7]!="")
                        $infrastructure->setIP($r[7]);
                    if($r[8]!="")
                        $infrastructure->setHYPERV($r[8]);
                    if($r[9]!="")
                        $infrastructure->setNominal($r[9]);
                    $manager=$this->getDoctrine()->getManager();
                    $manager->persist($infrastructure);
                    $manager->flush();

                }
            }else{
              //  dd($fileinfra);

                dd('infra ' .$fileinfra. " ".\SimpleXLSX::parseError());

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
        $fileFolder = __DIR__ . '/../../public/uploads/DB/Infrastructures';
        $filePathName = md5(uniqid()) . $file->getClientOriginalName();
        try {
            $res = $file->move($fileFolder, $filePathName);

        } catch (FileException $e) {
        }
        return $res;
    }
}
