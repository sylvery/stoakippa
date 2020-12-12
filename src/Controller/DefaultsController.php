<?php

namespace App\Controller;

use App\Entity\Appuser;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultsController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
      $user = $this->getUser();
    	if ($user) {
        if ($this->isGranted('ROLE_CASHIER')) {
          // return redirectToRoute('transaction_index')
        }
        if ($this->isGranted('ROLE_USER')) {
          return $this->render('defaults/home.html.twig');
        }
    		return $this->redirectToRoute('user_index');
    	}
      return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/test-user", name="test_user")
    */
    public function testUser(EntityManager $entityManager, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
      $user = new Appuser();
      $user
        ->setPassword($userPasswordEncoderInterface->encodePassword($user, 'password'))
        ->setUsername('admin-'.rand(1))
      ;
      $entityManager->persist($user);
      $entityManager->flush();
      $this->addFlash('success','your username is ' . $user->getUsername() . ' and the password is password' );
      return $this->redirectToRoute('home');
    }
}
