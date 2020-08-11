<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
  /**
   * @Route("/panier/{id}", name="panier_ajout")
   */
    public function addPanier(Request $request, Produits $produit, SessionInterface $session)
    {
        $panier  = $session->get('panier', []);
        $id = $produit->getId();
        if (array_key_exists($id, $panier)) {
            //si la qté est different de null
            if ($request->query->get('qte') != null) {
                $panier[$id] = $request->query->get('qte');
                $this->addFlash('success', 'Quantité modifiée');
            }
        } else {
            if ($request->query->get('qte') != null) {
                //notre panier prend la nouvelle qté modifiée(on dans la page de presentation)
                $panier[$id] = $request->query->get('qte');
            } else {
                $panier[$id] = 1;
                $this->addFlash('success', 'Produit ajouté');
            }
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute("panier_index");
    }

    /**
   * @Route("/supprimer/{id}", name="panier_prod_sup")
   */
  public function supPanier(Produits $produit, SessionInterface $session)
  { 
    $panier  = $session->get('panier', []);
    $id = $produit->getId();
    if (array_key_exists($id, $panier)) {
        unset($panier[$id]);
        $this->addFlash('success', 'Produit supprimé');
      } 
      $session->set('panier', $panier);
      return $this->redirectToRoute("panier_index");
  }
    /**
   * @Route("/panier", name="panier_index")
   */
  public function panier(SessionInterface $session, ProduitsRepository $produitsRepo)
  {
    $panier = $session->get('panier', []) ;
    $produits = $produitsRepo->findByIdPanier((array_keys($panier)));
    return $this->render('panier/panier.html.twig', [
          'produits'=>$produits,
          'panier'=>$panier,
      ]);
  }
}
