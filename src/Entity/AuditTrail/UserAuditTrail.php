<?php

namespace App\Entity\AuditTrail;

use App\Entity\User;
use App\Repository\AuditTrail\UserAuditTrailRepository;
use App\Service\AuditTrail\AbstractAuditTrailEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAuditTrailRepository::class)
 */
class UserAuditTrail extends AbstractAuditTrailEntity
{

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userAuditTrails")
     */
    private $entity;

    public function getEntity(): ?User
    {
        return $this->entity;
    }

    public function setEntity(?User $entity): self
    {
        $this->entity = $entity;

        return $this;
    }
}
