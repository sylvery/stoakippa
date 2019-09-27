<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
