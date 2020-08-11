<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_index")
     */
    public function index(ProduitsRepository $produitRepo, SessionInterface $session)
    {
        $produits =$produitRepo->findBy(['disponibilite' => 1]);
        if(!$produits){
           throw $this->createNotFoundException('Pas produit disponible');
        }
        //S'il y a un produit dans mon panier j'enleve son bouton ajouter au panier
        $panier = $session->get('panier', []) ;
        return $this->render('produits/index.html.twig', [
            'produits'=>$produits,
            'panier'=>$panier
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
