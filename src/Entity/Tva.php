<?php

namespace App\Entity;

use App\Repository\TvaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TvaRepository::class)
 */
class Tva
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $multiplicateur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMultiplicateur(): ?float
    {
        return $this->multiplicateur;
    }

    public function setMultiplicateur(float $multiplicateur): self
    {
        $this->multiplicateur = $multiplicateur;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getValeur(): ?float
    {
        return $this->valeur;
    }

    public function setValeur(float $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
}
