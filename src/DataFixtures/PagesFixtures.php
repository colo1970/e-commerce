<?php

namespace App\DataFixtures;

use App\Entity\Pages;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PagesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $page1 = new Pages();
        $page1->setTitre('QUI SOMMES-NOUS ?')
              ->setContenu("Créée en 2016, ...");
        $manager->persist($page1);
        $page2 = new Pages();
        $page2->setTitre('MENTIONS LÉGALES')
              ->setContenu("Créée en 2016, ...");
        $manager->persist($page2);

        /*$page1 = new Pages();
        $page1->setTitre('CONTACT')
              ->setContenu("Ecriver nous à l'adrsse, ...");
        $manager->persist($page1);
        $page1 = new Pages();
        $page1->setTitre('TÉMOIGNAGES')
              ->setContenu("Je suis très content, ...");
        $manager->persist($page1);
        */
        $manager->flush();
    }
}
