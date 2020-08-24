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
        $produit1->setDescription("Le poivron rouge est un groupe de cultivars de l'espèce Capsicum annuum.");
        $produit1->setDisponibilite('1');
        $produit1->setImage($this->getReference('img2'));
        $produit1->setNom('Poivron rouge');
        $produit1->setPrixht('1.99');
        $produit1->setQuantite(7);
        $produit1->setPoids(1.5);
        $produit1->setDateCreaAt(new \DateTime());
        $produit1->setTva($this->getReference('tva1'));
        $manager->persist($produit1);

        $produit2 = new Produits();
        $produit2->setCategorie($this->getReference('categorie2'));
        $produit2->setDescription("Piment est généralement associé à la saveur du piquant (pimenté).");
        $produit2->setDisponibilite('1');
        $produit2->setImage($this->getReference('img3'));
        $produit2->setNom('Piment');
        $produit2->setPrixht(3.99);
        $produit2->setQuantite(7);
        $produit2->setPoids(1.5);
        $produit2->setDateCreaAt(new \DateTime());
        $produit2->setTva($this->getReference('tva2'));
        $manager->persist($produit2);

        $produit3 = new Produits();
        $produit3->setCategorie($this->getReference('categorie1'));
        $produit3->setDescription("La tomate est une espèce de plantes herbacées de la famille des Solanacées, originaire du nord-ouest de l'Amérique du Sud.");
        $produit3->setDisponibilite('1');
        $produit3->setImage($this->getReference('img4'));
        $produit3->setNom('Tomate');
        $produit3->setPrixht(0.99);
        $produit3->setQuantite(7);
        $produit3->setPoids(1.5);
        $produit3->setDateCreaAt(new \DateTime());
        $produit3->setTva($this->getReference('tva2'));
        $manager->persist($produit3);
        
        $produit4 = new Produits();
        $produit4->setCategorie($this->getReference('categorie1'));
        $produit4->setDescription("Le poivron vert est un groupe de cultivars de l'espèce Capsicum annuum.");
        $produit4->setDisponibilite('1');
        $produit4->setImage($this->getReference('img1'));
        $produit4->setNom('Poivron vert');
        $produit4->setPrixht(2.99);
        $produit4->setQuantite(7);
        $produit4->setPoids(1.5);
        $produit4->setDateCreaAt(new \DateTime());
        $produit4->setTva($this->getReference('tva2'));
        $manager->persist($produit4);
        
        $produit5 = new Produits();
        $produit5->setCategorie($this->getReference('categorie2'));
        $produit5->setDescription("Le raisin est le fruit de la Vigne. Le raisin de la vigne cultivée Vitis vinifera est un des fruits les plus cultivés au monde, avec 68 millions de tonnes produites en 2010.");
        $produit5->setDisponibilite('1');
        $produit5->setImage($this->getReference('img5'));
        $produit5->setNom('Raisin');
        $produit5->setPrixht(0.97);
        $produit5->setQuantite(7);
        $produit5->setPoids(1.5);
        $produit5->setDateCreaAt(new \DateTime());
        $produit5->setTva($this->getReference('tva2'));
        $manager->persist($produit5);
        
        $produit6 = new Produits();
        $produit6->setCategorie($this->getReference('categorie2'));
        $produit6->setDescription("L’orange est un agrume, fruit des orangers, des arbres de différentes espèces de la famille des Rutacées ou d'hybrides de ceux-ci.");
        $produit6->setDisponibilite('1');
        $produit6->setImage($this->getReference('img6'));
        $produit6->setNom('Orange');
        $produit6->setPrixht(1.20);
        $produit6->setQuantite(7);
        $produit6->setPoids(1.5);
        $produit6->setDateCreaAt(new \DateTime());
        $produit6->setTva($this->getReference('tva2'));
        $manager->persist($produit6);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 5;
    }
}
