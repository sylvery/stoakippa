<?php

namespace App\DataFixtures;

use App\Entity\Appuser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passEnc;
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->passEnc = $userPasswordEncoderInterface;
    }
    public function load(ObjectManager $manager)
    {
        $appuser = new Appuser();
        $appuser
            ->setUsername('admin')
            ->setPassword($this->passEnc->encodePassword($appuser, 'password'))
            ->setRoles(['ROLE_ADMIN' => 'ROLE_ADMIN'])
        ;
        $manager->persist($appuser);

        $manager->flush();
    }
}
