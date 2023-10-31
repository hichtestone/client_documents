<?php

namespace App\Entity\AuditTrail;

use App\Entity\Equipement;
use App\Repository\AuditTrail\EquipementAuditTrailRepository;
use App\Service\AuditTrail\AbstractAuditTrailEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipementAuditTrailRepository::class)
 */
class EquipementAuditTrail extends AbstractAuditTrailEntity
{

    /**
     * @ORM\ManyToOne(targetEntity=Equipement::class, inversedBy="equipementAuditTrails")
     */
    private $entity;


    public function getEntity(): ?Equipement
    {
        return $this->entity;
    }

    public function setEntity(?Equipement $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
