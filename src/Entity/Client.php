<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use App\Service\AuditTrail\AuditTrailAssociableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @method string getUserIdentifier()
 */
class Client  implements UserInterface, PasswordAuthenticatedUserInterface, AuditTrailAssociableInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainedPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true))
     */
    private $email;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $contrat;



    /**
     * @ORM\OneToMany(targetEntity=Infrastructure::class, mappedBy="client")
     */
    private $infrastructures;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="client")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=Equipement::class, mappedBy="client")
     */
    private $equipements;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="clients")
     */
    private $companies;

    /**
     * @return mixed
     */
    public function getCompanyInterne()
    {
        return $this->companyInterne;
    }

    /**
     * @param mixed $companyInterne
     */
    public function setCompanyInterne($companyInterne): void
    {
        $this->companyInterne = $companyInterne;
    }

    /**
     * @ORM\ManyToOne(targetEntity=CompanyInterne::class, inversedBy="clients")
     */
    private $companyInterne;

    public function __construct()
    {

        $this->infrastructures = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->equipements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return ["ROLE_ADMIN"];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContrat(): ?bool
    {
        return $this->contrat;
    }

    public function setContrat(?bool $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }


    /**
     * @return Collection|Infrastructure[]
     */
    public function getInfrastructures(): Collection
    {
        return $this->infrastructures;
    }

    public function addInfrastructure(Infrastructure $infrastructure): self
    {
        if (!$this->infrastructures->contains($infrastructure)) {
            $this->infrastructures[] = $infrastructure;
            $infrastructure->setClient($this);
        }

        return $this;
    }

    public function removeInfrastructure(Infrastructure $infrastructure): self
    {
        if ($this->infrastructures->removeElement($infrastructure)) {
            // set the owning side to null (unless already changed)
            if ($infrastructure->getClient() === $this) {
                $infrastructure->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setClient($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getClient() === $this) {
                $document->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Equipement[]
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(Equipement $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setClient($this);
        }

        return $this;
    }

    public function removeEquipement(Equipement $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getClient() === $this) {
                $equipement->setClient(null);
            }
        }

        return $this;
    }

    public function getCompanies(): ?Company
    {
        return $this->companies;
    }

    public function setCompanies(?Company $companies): self
    {
        $this->companies = $companies;

        return $this;
    }
    public function pathShow()
    {
        return route('client_show', ['id' => $this->id]);
    }

    public function getCountryInterne(): ?CompanyInterne
    {
        return $this->companyInterne;
    }

    public function setCountryInterne(?CompanyInterne $companyInterne): self
    {
        $this->companyInterne = $companyInterne;

        return $this;
    }

    public function getAuditTrailString(): string
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}
