<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
  /**
   * @Route("/panier", name="panier_index")
   */
    public function panier()
    {
        return $this->render('panier/panier.html.twig');
    }
}
