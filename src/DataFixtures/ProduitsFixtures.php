<?php

namespace App\DataFixtures;

use App\Entity\Produits;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ProduitsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $produit1 = new Produits();
        $produit1->setCategorie($this->getReference('categorie1'));
        $produit1->setDescription("Ananas ");
        $produit1->setDisponibilite('1');
        $produit1->setImage($this->getReference('img1'));
        $produit1->setNom('Ananas');
        $produit1->setQuantite(1);
        $produit1->setPoids(0.5);
        $produit1->setPrixht('1.99');
        $produit1->setDateCreaAt(new \DateTime());
        $produit1->setTva($this->getReference('tva1'));
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setCategorie($this->getReference('categorie2'));
        $produit2->setDescription("Carrotte");
        $produit2->setDisponibilite('1');
        $produit2->setImage($this->getReference('img2'));
        $produit2->setNom('Carrotte');
        $produit2->setQuantite(7);
        $produit2->setPoids(1.5);
        $produit2->setPrixht('1.20');
        $produit2->setDateCreaAt(new \DateTime());
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 5;
    }
}
