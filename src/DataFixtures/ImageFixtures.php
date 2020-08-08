<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class ImageFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) {
        $image1 = new Image();
        $image1->setPath('f.jpg');
        $image1->setAlt('test1');
        $manager->persist($image1);
        
        $image2 = new Image();
        $image2->setPath('f.jpg');
        $image2->setAlt('test2');

        $manager->persist($image2);
        $manager->flush();
        /*addReference permet de faire la relation avec d'autres fixtures en donnant un nom à une entité afin d'autres fixtures
          puissent le recuperer:   $this-->getReference('img1')
         */
        
        $this->addReference('img1', $image1);
        $this->addReference('img2', $image2);
    }
    // getOrder() indique l'ordre de chargement des fixtures 
    public function getOrder()
    {
        return 1;
    }
}
