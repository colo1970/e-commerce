<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/apropos", name="home_apropos")
     */
    public function propos()
    {
        return $this->render('home/apropos.html.twig');
    }

      /**
     * @Route("/temoignage", name="home_temoignage")
     */
    public function temoignage()
    {
        return $this->render('home/temoignage.html.twig');
    }

    /**
     * @Route("/contact", name="home_contact")
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig');
    }

  
}
