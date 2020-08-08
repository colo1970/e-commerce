<?php

namespace App\DataFixtures;

use App\Entity\Tva;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class TvaFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tva1 = new Tva();
        $tva1->setMultiplicateur('0.982'); //1-(1.75/100)
        $tva1->setNom('TVA 1.75%');
        $tva1->setValeur('1.75');
        $manager->persist($tva1);
        
        $tva2 = new Tva();
        $tva2->setMultiplicateur('0.8');// prix -(prix * 20/100) = prix-prix(1-0.2)
        $tva2->setNom('TVA 20%');
        $tva2->setValeur('20');
        $manager->persist($tva2);
        $manager->flush();
        
        $this->addReference('tva1', $tva1);//stock l'entity $tva1 dans tva1, acces dans ProduitFixture $this->getReference('tva1') pour faire le lien
        $this->addReference('tva2', $tva2);
    }
    public function getOrder()
    {
        return 3;
    }
}
