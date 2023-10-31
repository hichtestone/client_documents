<?php

namespace App\Controller;

use App\Entity\AuditTrail\DocumentAuditTrail;
use App\Entity\Document;
use App\Repository\AuditTrail\DocumentAuditTrailRepository;
use App\Repository\AuditTrail\EquipementAuditTrailRepository;
use App\Repository\AuditTrail\InfrastructureAuditTrailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("audit/trail")
 */
class AuditTrailController extends AbstractController
{
    /**
     * @Route("/", name="audit_trail")
     */
    public function index(DocumentAuditTrailRepository $repository,
                          InfrastructureAuditTrailRepository $infrastructureAuditTrailRepository,
                          EquipementAuditTrailRepository $equipementAuditTrailRepository): Response
    {
        $equipementsAuditTrail=$equipementAuditTrailRepository->findAll();
        $infrastructuresAuditTrail=$infrastructureAuditTrailRepository->findAll();
        $documentAuditTrail=$repository->findAll();

        return $this->render('audit_trail/index.html.twig', [
            'documentsAuditTrail'=>$documentAuditTrail,
            'equipementsAuditTrail'        => $equipementsAuditTrail,
            'infrastructuresAuditTrail'    =>$infrastructuresAuditTrail,
        ]);
    }



}
