<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index")
     */
    public function index(ProduitsRepository $produitRepo)
    {
        return $this->render('produits/index.html.twig', [
            'produits'=>$produitRepo->findAll
        ]);
    }
   
    /**
     * @Route("/fruit", name="produits_fruit")
     */
    public function fruit()
    {
        return $this->render('produits/fruit.html.twig');
    }
}
