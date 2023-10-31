<?php

namespace App\Entity;

use App\Entity\AuditTrail\UserAuditTrail;
use App\Repository\UserRepository;
use App\Service\AuditTrail\AuditTrailAssociableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface, AuditTrailAssociableInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isAdmin;

    /**
     * @ORM\OneToMany(targetEntity=UserAuditTrail::class, mappedBy="entity")
     */
    private $userAuditTrails;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyInterne::class, inversedBy="users")
     */
    private $companyInterne;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->userAuditTrails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getAuditTrailString(): string
    {
        return $this->getUsername();
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * @return Collection|UserAuditTrail[]
     */
    public function getUserAuditTrails(): Collection
    {
        return $this->userAuditTrails;
    }

    public function addUserAuditTrail(UserAuditTrail $userAuditTrail): self
    {
        if (!$this->userAuditTrails->contains($userAuditTrail)) {
            $this->userAuditTrails[] = $userAuditTrail;
            $userAuditTrail->setEntity($this);
        }

        return $this;
    }

    public function removeUserAuditTrail(UserAuditTrail $userAuditTrail): self
    {
        if ($this->userAuditTrails->removeElement($userAuditTrail)) {
            // set the owning side to null (unless already changed)
            if ($userAuditTrail->getEntity() === $this) {
                $userAuditTrail->setEntity(null);
            }
        }

        return $this;
    }
    public function getFieldsToBeIgnored(): array
    {
        return ['companyInterne'];
    }

    public function getCompanyInterne(): ?CompanyInterne
    {
        return $this->companyInterne;
    }

    public function setCompanyInterne(?CompanyInterne $companyInterne): self
    {
        $this->companyInterne = $companyInterne;

        return $this;
    }
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }


    public function unserialize($data)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($data);
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
