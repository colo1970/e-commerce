<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/", name="produits_produits")
     */
    public function produits(ProduitsRepository $produitRepo, SessionInterface $session, PaginatorInterface $paginator, Request $request)
    {
        $produitsRepo = $produitRepo->findBy(['disponibilite' => 1]);
        if(!$produitsRepo){
           throw $this->createNotFoundException('Pas produit disponible');
        }
        $produits = $paginator->paginate($produitsRepo, $request->query->getInt('page', 1), 2 );
        //S'il y a un produit dans mon panier j'enleve son bouton ajouter au panier
        $panier = $session->get('panier', []) ;
        return $this->render('produits/produits.html.twig', [
            'produits'=>$produits,
            'panier'=>$panier
        ]);
    }
   
    /**
     * @Route("/presentation/{id}", name="produits_presentation")
     */
    public function presentation(Produits $produit, SessionInterface $session)
    {
        $panier = $session->get('panier', []) ;
        return $this->render('produits/presentation.html.twig',[
            'produit'=>$produit,
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
