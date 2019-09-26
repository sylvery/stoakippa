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
    	if ($this->getUser()) {
    		return $this->redirectToRoute('home');
    	}
      return $this->redirectToRoute('app_login');
    }
}
