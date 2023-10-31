<?php

namespace App\Entity;

use App\Entity\AuditTrail\EquipementAuditTrail;
use App\Repository\EquipementRepository;
use App\Service\AuditTrail\AuditrailableInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipementRepository::class)
 */
class Equipement implements AuditrailableInterface
{
    public const TYPE_RESEAU = 1;
    public const TYPE_PERIPH = 2;
    public const TYPE_WEB = 3;
    public const TYPE = [
        self::TYPE_RESEAU => 'Réseau',
        self::TYPE_PERIPH => 'Phériphérique',
        self::TYPE_WEB => 'Web',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $TYPE;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="equipements")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=EquipementAuditTrail::class, mappedBy="entity")
     */
    private $equipementAuditTrails;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function __construct()
    {
        $this->equipementAuditTrails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTYPE()
    {
        return $this->TYPE;
    }

    /**
     * @param mixed $TYPE
     */
    public function setTYPE($TYPE): void
    {
        if (!array_key_exists($TYPE, self::TYPE) && $TYPE !== null) {
            throw new \Exception('le type ' . $TYPE . ' n\'existe pas !');
        }

        $this->TYPE = $TYPE;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

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

    public function encrypt($simple_string)
    {
        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';

        // Store the encryption key
        $encryption_key = "GeeksforGeeks";

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($simple_string, $ciphering,
            $encryption_key, $options, $encryption_iv);
        return $encryption;






    }

    public function decrype($encryption)
    {

        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';

        // Store the decryption key
        $decryption_key = "GeeksforGeeks";

        // Use openssl_decrypt() function to decrypt the data
        $decryption=openssl_decrypt ($encryption, $ciphering,
            $decryption_key, $options, $decryption_iv);

        // Display the decrypted string
       // echo "Decrypted String: " . $decryption;
             return $decryption;
    }

    /**
     * @return Collection|EquipementAuditTrail[]
     */
    public function getEquipementAuditTrails(): Collection
    {
        return $this->equipementAuditTrails;
    }

    public function addEquipementAuditTrail(EquipementAuditTrail $equipementAuditTrail): self
    {
        if (!$this->equipementAuditTrails->contains($equipementAuditTrail)) {
            $this->equipementAuditTrails[] = $equipementAuditTrail;
            $equipementAuditTrail->setEntity($this);
        }

        return $this;
    }

    public function removeEquipementAuditTrail(EquipementAuditTrail $equipementAuditTrail): self
    {
        if ($this->equipementAuditTrails->removeElement($equipementAuditTrail)) {
            // set the owning side to null (unless already changed)
            if ($equipementAuditTrail->getEntity() === $this) {
                $equipementAuditTrail->setEntity(null);
            }
        }

        return $this;
    }

    public function getFieldsToBeIgnored(): array
    {
        return ['client'];
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
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
