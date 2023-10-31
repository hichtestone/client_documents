<?php

namespace App\Controller;

use App\Entity\CompanyInterne;
use App\Form\CompanyInterneType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company/interne")
 */
class CompanyInterneController extends AbstractController
{
    /**
     * @Route("/{id}", name="company_interne_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CompanyInterne $companyInterne): Response
    {
        $form=$this->createForm(CompanyInterneType::class, $companyInterne);
        $form->handleRequest($request);
        $compnaies=$this->getDoctrine()->getRepository(CompanyInterne::class)->findAll();
        if($form->isSubmitted() && $form->isValid()){
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($companyInterne);
            $entityManager->flush();

            return $this->redirectToRoute('home',[
                'companies'=>$compnaies,
            ]);
        }
        return $this->render('company_interne/index.html.twig', [
            'companyinterne'=>$companyInterne,
            'form'=>$form->createView(),

        ]);
    }
}
