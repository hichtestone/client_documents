<?php

namespace App\Entity\AuditTrail;

use App\Entity\Document;
use App\Repository\DocumentAuditTrailRepository;
use App\Service\AuditTrail\AbstractAuditTrailEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentAuditTrailRepository::class)
 */
class DocumentAuditTrail extends AbstractAuditTrailEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="documentAuditTrails")
     */
    private $entity;

    public function getEntity(): ?Document
    {
        return $this->entity;
    }

    public function setEntity(?Document $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
