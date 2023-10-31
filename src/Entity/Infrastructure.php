<?php

namespace App\Entity;

use App\Entity\AuditTrail\InfrastructureAuditTrail;
use App\Repository\InfrastructureRepository;
use App\Service\AuditTrail\AuditrailableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfrastructureRepository::class)
 */
class Infrastructure implements AuditrailableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomSvr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $OS;

    /**
     * @ORM\Column(type="string",  length=255, nullable=true)
     */
    private $CPU_PROC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RAM;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $totalDisque;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $DisqueUsed;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $IP;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $HYPERV;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nominal;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class,  inversedBy="infrastructures")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=InfrastructureAuditTrail::class, mappedBy="entity")
     */
    private $infrastructureAuditTrails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->infrastructureAuditTrails = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param mixed $site
     */
    public function setSite($site): void
    {
        $this->site = $site;
    }

    /**
     * @return mixed
     */
    public function getNomSvr()
    {
        return $this->nomSvr;
    }

    /**
     * @param mixed $nomSvr
     */
    public function setNomSvr($nomSvr): void
    {
        $this->nomSvr = $nomSvr;
    }

    /**
     * @return mixed
     */
    public function getOS()
    {
        return $this->OS;
    }

    /**
     * @param mixed $OS
     */
    public function setOS($OS): void
    {
        $this->OS = $OS;
    }

    /**
     * @return mixed
     */
    public function getCPUPROC()
    {
        return $this->CPU_PROC;
    }

    /**
     * @param mixed $CPU_PROC
     */
    public function setCPUPROC($CPU_PROC): void
    {
        $this->CPU_PROC = $CPU_PROC;
    }

    /**
     * @return mixed
     */
    public function getRAM()
    {
        return $this->RAM;
    }

    /**
     * @param mixed $RAM
     */
    public function setRAM($RAM): void
    {
        $this->RAM = $RAM;
    }

    /**
     * @return mixed
     */
    public function getTotalDisque()
    {
        return $this->totalDisque;
    }

    /**
     * @param mixed $totalDisque
     */
    public function setTotalDisque($totalDisque): void
    {
        $this->totalDisque = $totalDisque;
    }

    /**
     * @return mixed
     */
    public function getDisqueUsed()
    {
        return $this->DisqueUsed;
    }

    /**
     * @param mixed $DisqueUsed
     */
    public function setDisqueUsed($DisqueUsed): void
    {
        $this->DisqueUsed = $DisqueUsed;
    }

    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param mixed $IP
     */
    public function setIP($IP): void
    {
        $this->IP = $IP;
    }

    /**
     * @return mixed
     */
    public function getHYPERV()
    {
        return $this->HYPERV;
    }

    /**
     * @param mixed $HYPERV
     */
    public function setHYPERV($HYPERV): void
    {
        $this->HYPERV = $HYPERV;
    }

    /**
     * @return mixed
     */
    public function getNominal()
    {
        return $this->nominal;
    }

    /**
     * @param mixed $nominal
     */
    public function setNominal($nominal): void
    {
        $this->nominal = $nominal;
    }



    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|InfrastructureAuditTrail[]
     */
    public function getInfrastructureAuditTrails(): Collection
    {
        return $this->infrastructureAuditTrails;
    }

    public function addInfrastructureAuditTrail(InfrastructureAuditTrail $infrastructureAuditTrail): self
    {
        if (!$this->infrastructureAuditTrails->contains($infrastructureAuditTrail)) {
            $this->infrastructureAuditTrails[] = $infrastructureAuditTrail;
            $infrastructureAuditTrail->setEntity($this);
        }

        return $this;
    }

    public function removeInfrastructureAuditTrail(InfrastructureAuditTrail $infrastructureAuditTrail): self
    {
        if ($this->infrastructureAuditTrails->removeElement($infrastructureAuditTrail)) {
            // set the owning side to null (unless already changed)
            if ($infrastructureAuditTrail->getEntity() === $this) {
                $infrastructureAuditTrail->setEntity(null);
            }
        }

        return $this;
    }

    public function getFieldsToBeIgnored(): array
    {
        return ['client'];
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
