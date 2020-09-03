<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setEmail('o.daffe@yahoo.fr');
        $password = $this->encoder->encodePassword($user1, 'dev');
        $user1->setPassword($password);
        $manager->persist($user1);

        $user2= new User();
        $user2->setEmail('o.daffe@laposte.net');
        $password = $this->encoder->encodePassword($user2, 'dev');
        $user2->setPassword($password);
        $manager->persist($user2);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
    }
    public function getOrder()
    {
        return 4;
    }
}
