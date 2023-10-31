<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\CompanyInterne;
use App\Entity\Equipement;
use App\Entity\Infrastructure;
use App\Form\ClientType;
use App\Form\EquipementType;
use App\Form\InfrastructureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;
use Nullix\CryptoJsAes\CryptoJsAes;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{


    private $encoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;

    }


    /**
     * @Route("/", name="client",methods={"GET"})
     */
    public function index(Request  $request): Response
    {
        $companyInterne = $this->getDoctrine()->getManager()->getRepository(CompanyInterne::class)->findOneBy(["id"=>$request->getSession()->get('companyInterne')]);
        //dd($companyInterne);
        //  $request->getSession()->get('companyInterne');
        if($this->getUser()->getCompanyInterne() !== null){
           // $company=$this->getDoctrine()->getManager()->getRepository(CompanyInterne::class)->findAll();

            $clients=$this->getDoctrine()->getManager()->getRepository(Client::class)->findBy(['companyInterne'=>$companyInterne->getId()]);
//dd($clients);
            return $this->render('client/index.html.twig', [
                'clients' => $clients,
            ]);
        }else{
            $clients=$this->getDoctrine()->getManager()->getRepository(Client::class)->findBy(['companyInterne'=>$request->getSession()->get('companyInterne')]);
//dd($clients);
            return $this->render('client/index.html.twig', [
                'clients' => $clients,
            ]);

        }

    }

    public function encrypt($simple_string, $encryption_key )
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';


        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
        return $encryption;

    }
    /**
     * @Route("/showclient/ajax", name="client_show_ajax", methods={"GET", "POST"})
     */
    public function showAjax(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            $tabs=$request->get('tabpasswords');

            $equipement=$this->getDoctrine()->getRepository(Equipement::class)->findOneBy(['id'=>$request->get('equipement')]);
            //dd($equipement);

            return $this->render('client/pass.html.twig', [
                'tabs' => $tabs,
                'equipement'=>$equipement,

            ]);
            return new JsonResponse($tabs);
        }
    }

    /**
     * @Route("/{id}/showclient", name="client_show", methods={"GET", "POST"})
     * @param Client $client
     */
    public function show(Client $client, Request  $request): Response
    {

        $request->getSession()->set("token",md5(uniqid()));
        $token=$request->getSession()->get("token");
   // dd($token);
        $passwords=[];
        foreach ($client->getEquipements() as $equipement){
           $passwords[]=CryptoJsAes::encrypt($equipement->getPassword(), $token);
        }
        return $this->render('client/show.html.twig', [
            'client' => $client,
            'passwords'=>$passwords,

                    ]);
    }
    /**
     * @Route("/new", name="client_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $client= new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('client');
        }

        return $this->render('client/edit.html.twig', [
            'edit'=>false,
            'client' => $client,
            'form'=>$form->createView(),

        ]);
    }

    /**
     * @Route("/{id}/editclient", name="client_edit", methods={"GET", "POST"}, requirements={"id":"\d+"})
     * @param Client $client
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_show', [
                'id'=>$client->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form'=>$form->createView(),
            'edit'=>true,
        ]);
    }

    /**
     * @Route("/typeAhead/{query?}", name="typeAhead", methods={"POST", "GET"})
     */
    public function typeAheadAllAction(Request $request,$query)
    {
        $companyInterne = $request->getSession()->get('companyInterne');
        $clientstab=$this->getDoctrine()->getRepository(Client::class)->searchClientByCompanyName($query, $companyInterne);
      //  dd($clientstab);
        $clients=array();

        foreach($clientstab as $client){
            //$ch=$client->getLastName()+" "+ $client->getFirstName();
            $clients[]=['id'        =>$client->getId(),
                        'firstName' =>$client->getFirstName(),
                        'lastName'  =>$client->getLastName(),
                    ];
        }

        return new JsonResponse($clients);
    }

    /**
     * @Route("/{id}/show_equipement", name="show_equipement", methods={"GET"})
     */
    public function showEquipement(Equipement $equipement):Response
    {

      //  dd($equipement);
        return  $this->render('equipement/modal_show.html.twig',[
            'equipement'=>$equipement,
        ]);
    }

    /**
     * @Route("/{id}/edit_equipement", name="edit_equipement", methods={"GET", "POST"})
     */
    public function editEquipement(Request $request, Equipement $equipement):Response
    {
        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipement->setPassword($equipement->encrypt($equipement->getPassword()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$equipement->getClient()->getId(),
            ]);
        }

        return $this->render('equipement/modal_edit.html.twig',[
            'form' => $form->createView(),
            'equipement'=>$equipement,
        ]);
        //  dd($equipement);

    }

    /**
     * @Route("/{id}/show_infrastructure", name="show_infrastructure", methods={"GET"})
     */
    public function showInfrastructrure(Infrastructure $infrastructure):Response
    {

        //  dd($equipement);
        return  $this->render('infrastructure/show.html.twig',[
            'infrastructure'=>$infrastructure,
        ]);
    }

    /**
     * @Route("/{id}/edit_infrastructure", name="edit_infrastructure", methods={"GET", "POST"})
     */
    public function editInfrastructure(Request $request, Infrastructure $infrastructure):Response
    {
        $form = $this->createForm(InfrastructureType::class, $infrastructure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($infrastructure);
            $entityManager->flush();

            return $this->redirectToRoute('client_show',[
                'id'=>$infrastructure->getClient()->getId(),
            ]);
        }

        return $this->render('infrastructure/modal_edit.html.twig',[
            'form' => $form->createView(),
            'infrastructure'=>$infrastructure,
        ]);
        //  dd($equipement);

    }
}
