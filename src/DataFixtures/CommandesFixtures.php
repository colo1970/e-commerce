<?php

namespace App\DataFixtures;

use App\Entity\Commandes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CommandesFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $commande1 = new Commandes();
        $commande1->setUser($this->getReference('user1'));
        $commande1->setValidation('1');
        $commande1->setDateAt(new \DateTime());
        $commande1->setReference('1');
        $commande1->setPanier(array('0' => array('1' => '2'),
                                      '1' => array('2' => '1'),
                                      '2' => array('4' => '5')
                                ));
        $manager->persist($commande1);
        
        $commande2 = new Commandes();
        $commande2->setUser($this->getReference('user2'));
        $commande2->setValidation('1');
        $commande2->setDateAt(new \DateTime());
        $commande2->setReference('2');
        $commande2->setPanier(array('0' => array('1' => '2'),
                                      '1' => array('2' => '1'),
                                      '2' => array('4' => '5')
                                ));
        $manager->persist($commande2);
        $manager->flush();
    }
    public function getOrder()
    {
        return 6;
    }
}
