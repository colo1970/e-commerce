<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index")
     */
    public function index()
    {
        return $this->render('produits/index.html.twig');
    }
    /**
     * @Route("/fruit", name="produits_fruit")
     */
    public function fruit()
    {
        return $this->render('produits/fruit.html.twig');
    }
}
