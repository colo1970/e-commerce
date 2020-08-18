<?php

namespace App\Controller;

use App\Entity\Commandes;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ValidationController extends AbstractController
{
  /**
   * @Route("/commande", name="commande_commande")
   */
  public function prepareCommande(SessionInterface $session)
  {
     $commande = $session->get('commande', []);
     if(empty($commande)){
       $commande = new Commandes();
     }else{
      $commande = $session->get('commande', []);
     }
     $commande->setValidation(0);
     $commande->setReference(0);
     $commande->setUser($this->getUser());
     $commande->setDateAt(new \DateTime());
     $commande->setPanier();
     dd($commande);
     return $this->redirectToRoute('panier_livraison');
  }
}

