<?php

namespace App\Entity\AuditTrail;

use App\Entity\Infrastructure;
use App\Repository\AuditTrail\InfrastructureAuditTrailRepository;
use App\Service\AuditTrail\AbstractAuditTrailEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfrastructureAuditTrailRepository::class)
 */
class InfrastructureAuditTrail extends AbstractAuditTrailEntity
{


    /**
     * @ORM\ManyToOne(targetEntity=Infrastructure::class, inversedBy="infrastructureAuditTrails")
     */
    private $entity;

    public function getEntity(): ?Infrastructure
    {
        return $this->entity;
    }

    public function setEntity(?Infrastructure $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
