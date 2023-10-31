<?php

namespace App\Entity;

use App\Entity\AuditTrail\DocumentAuditTrail;
use App\Repository\DocumentRepository;
use App\Service\AuditTrail\AuditrailableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @Vich\Uploadable
 */
class Document implements AuditrailableInterface
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
    private $licenseName;

    /**
     * @var File
     * @Vich\UploadableField (mapping="document_licence", fileNameProperty="licenseName")
     */
    private $licenceFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $configurationName;

    /**
     * @var File
     * @Vich\UploadableField (mapping="document_conf", fileNameProperty="configurationName")
     */
    private $configurationFile;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="documents")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=DocumentAuditTrail::class, mappedBy="entity")
     */
    private $documentAuditTrails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $detetedAt;

    public function __construct()
    {
        $this->documentAuditTrails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getLicenseName()
    {
        return $this->licenseName;
    }

    /**
     * @param mixed $licenseName
     */
    public function setLicenseName($licenseName): void
    {
        $this->licenseName = $licenseName;
    }



    public function getConfigurationName(): ?string
    {
        return $this->configurationName;
    }

    public function setConfigurationName(?string $configurationName): self
    {
        $this->configurationName = $configurationName;

        return $this;
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
     * @return File
     */
    public function getLicenceFile(): ?File
    {
        return $this->licenceFile;
    }

    public function setLicenceFile($licenceFile): Document
    {
        $this->licenceFile = $licenceFile;

        if ($this->licenceFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime();
        }
        return $this;
    }

    /**
     * @return File
     */
    public function getConfigurationFile(): ?File
    {
        return $this->configurationFile;
    }

    public function setConfigurationFile($configurationFile): Document
    {
        $this->configurationFile = $configurationFile;

        if ($this->configurationFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime();
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|DocumentAuditTrail[]
     */
    public function getDocumentAuditTrails(): Collection
    {
        return $this->documentAuditTrails;
    }

    public function addDocumentAuditTrail(DocumentAuditTrail $documentAuditTrail): self
    {
        if (!$this->documentAuditTrails->contains($documentAuditTrail)) {
            $this->documentAuditTrails[] = $documentAuditTrail;
            $documentAuditTrail->setEntity($this);
        }

        return $this;
    }

    public function removeDocumentAuditTrail(DocumentAuditTrail $documentAuditTrail): self
    {
        if ($this->documentAuditTrails->removeElement($documentAuditTrail)) {
            // set the owning side to null (unless already changed)
            if ($documentAuditTrail->getEntity() === $this) {
                $documentAuditTrail->setEntity(null);
            }
        }

        return $this;
    }

    public function getFieldsToBeIgnored(): array
    {
        return ['client'];
    }

    public function getDetetedAt(): ?\DateTimeInterface
    {
        return $this->detetedAt;
    }

    public function setDetetedAt(?\DateTimeInterface $detetedAt): self
    {
        $this->detetedAt = $detetedAt;

        return $this;
    }
}
