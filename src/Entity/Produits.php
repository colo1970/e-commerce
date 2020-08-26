<?php

namespace App\Entity;

use App\Entity\Image;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitsRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 * @Vich\Uploadable()
 */
class Produits
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     */
    private $prixht;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponibilite;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreaAt;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, inversedBy="produit", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Tva::class,cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tva;
    
    public function __construct()
    {
        $this->dateCreaAt=new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrixht(): ?float
    {
        return $this->prixht;
    }

    public function setPrixht(float $prixht): self
    {
        $this->prixht = $prixht;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(?float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(?float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    public function getDateCreaAt(): ?\DateTimeInterface
    {
        return $this->dateCreaAt;
    }

    public function setDateCreaAt(\DateTimeInterface $dateCreaAt): self
    {
        $this->dateCreaAt = $dateCreaAt;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getTva(): ?Tva
    {
        return $this->tva;
    }

    public function setTva(?Tva $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

}
