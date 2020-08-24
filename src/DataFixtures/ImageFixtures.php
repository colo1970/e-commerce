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

        $image3 = new Image();
        $image3->setPath('f.jpg');
        $image3->setAlt('test2');
        $manager->persist($image3);

        $image4 = new Image();
        $image4->setPath('f.jpg');
        $image4->setAlt('test2');
        $manager->persist($image4);

        $image5 = new Image();
        $image5->setPath('f.jpg');
        $image5->setAlt('test2');
        $manager->persist($image5);

        $image6 = new Image();
        $image6->setPath('f.jpg');
        $image6->setAlt('test2');
        $manager->persist($image6);

        $manager->flush();
        /*addReference permet de faire la relation avec d'autres fixtures en donnant un nom à une entité afin d'autres fixtures
          puissent le recuperer:   $this-->getReference('img1')
         */
        
        $this->addReference('img1', $image1);
        $this->addReference('img2', $image2);
        $this->addReference('img3', $image3);
        $this->addReference('img4', $image4);
        $this->addReference('img5', $image5);
        $this->addReference('img6', $image6);
    }
    // getOrder() indique l'ordre de chargement des fixtures 
    public function getOrder()
    {
        return 1;
    }
}
