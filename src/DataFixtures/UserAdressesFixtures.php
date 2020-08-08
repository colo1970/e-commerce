<?php

namespace App\DataFixtures;

use App\Entity\UserAdresses;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserAdressesFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $adresse1 = new UserAdresses();

        $adresse1->setUser($this->getReference('user1'));
        $adresse1->setNom('Daffe');
        $adresse1->setPrenom('Ousmane');
        $adresse1->setTelephone('0600000000');
        $adresse1->setAdresse('14, rue de vaise');
        $adresse1->setCp('76600');
        $adresse1->setPays('France');
        $adresse1->setVille('Le Havre');
        $adresse1->setDateCreAt(new \DateTime());
        $adresse1->setComplements('Près du marche');
        $manager->persist($adresse1);
        
        $adresse2 = new UserAdresses();
        $adresse2->setUser($this->getReference('user2'));
        $adresse2->setNom('Frederick');
        $adresse2->setPrenom('Dupont');
        $adresse2->setTelephone('0255889966');
        $adresse2->setAdresse('5 rue rubosca');
        $adresse2->setCp('76600');
        $adresse2->setPays('France');
        $adresse2->setDateCreAt(new \DateTime());
        $adresse2->setVille('Le Havre');
        $adresse2->setComplements('face à la plage');
        $manager->persist($adresse2);
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 7;
    }
}
