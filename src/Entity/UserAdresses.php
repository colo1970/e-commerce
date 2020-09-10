<?php

namespace App\Entity;

use App\Repository\UserAdressesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAdressesRepository::class)
 */
class UserAdresses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complements;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userAdresses")
     */
    private $user;

    public function __construct() {
        $this->dateCreAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getComplements(): ?string
    {
        return $this->complements;
    }

    public function setComplements(?string $complements): self
    {
        $this->complements = $complements;

        return $this;
    }

    public function getDateCreAt(): ?\DateTimeInterface
    {
        return $this->dateCreAt;
    }

    public function setDateCreAt(\DateTimeInterface $dateCreAt): self
    {
        $this->dateCreAt = $dateCreAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
