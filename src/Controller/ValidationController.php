<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Commandes;
use App\Services\Reference;
use App\Entity\UserAdresses;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class ValidationController extends AbstractController
{
  
  private $tokenGenerer;
  private $manager;
  private $session;
  public function __construct(TokenGeneratorInterface $tokenGenerer,SessionInterface $session, EntityManagerInterface $manager)
  {
    $this->tokenGenerer = $tokenGenerer;
    $this->session = $session;
    $this->manager = $manager;

  }
  /**
   * @Route("/commande", name="commande_commande")
   */
  public function prepareCommande()
  {
      $commande = $this->session->get('commande');
      //dd($commande);
      //dd(!$this->session->has('commande'));
      if(!$this->session->has('commande')){
          $commande = new Commandes(); 
      }else{   
        //dd($this->session->get('commande'));
        //On va utiliser la session qu’on a maintenant c'est-à-dire celle qu’on a déjà stockée : $session->get('commande')
        $commande =  $this->getDoctrine()->getRepository(Commandes::class)->find($this->session->get('commande'));
      }
    
      $commande->setValidation(0);
      $commande->setReference(0);
      $commande->setUser($this->getUser());
      $commande->setDateAt(new \DateTime());
      $commande->setItemsCommandes($this->itemsCommandes());
     //si la session commandes n’existe pas 
     if (!$this->session->has('commande')) {
        $this->manager->persist($commande);
      //resette la commande en session
        $this->session->set('commande', $commande);
    }
    /* si la session commande existe déjà on ne persiste pas, on va écraser les anciennes données pour les mettre à jour */
     $this->manager->flush();

    return new Response($commande->getId());
}
 
  /**
   * Stocker et retourne le produit, la livraison, les elements de facturation, prixht, prixTtc... de la vue validation
  */
  public function itemsCommandes()
  {
    //tableau qui stockera toutes les infos sur une commande
    $commandes = array();
    $totalHT = 0;
    $totalTVA = 0;
    //generer  un token pour api de payement
    $tokenGenerer = $this->tokenGenerer->generateToken();
    //Recupere l'adresse et le panier à partir de la session
    $idAdresses = $this->session->get('idAdresses', []);
    $panier = $this->session->get('panier', []);
    $userAdresseLiv=  $this->getDoctrine()->getRepository(UserAdresses::class)->find($idAdresses['livraison']);
    $userAdresseFact= $this->getDoctrine()->getRepository(UserAdresses::class)->find($idAdresses['facturation']);
    $produits = $this->getDoctrine()->getRepository(Produits::class)->findByIdPanier(array_keys($panier));
    foreach ($produits as $produit) {
      $prixHT = $produit->getPrixHt()* $panier[$produit->getId()];
      $prixTTC = $produit->getPrixHt() * $panier[$produit->getId()] / $produit->getTva()->getMultiplicateur();
      $totalHT += $prixHT;
      if (!isset($commandes['tva']['%' . $produit->getTva()->getValeur()])){
        //commandes tableau 2 dimension key : tva et valeur tva, il va contienir la tva de chaque produit, genre commandes["tva"]["%20"]
        $commandes['tva']['%' . $produit->getTva()->getValeur()] = round($prixTTC - $prixHT, 2);
      }
      else{
        //pour plusieurs articles, on rajoutera à chaque fois la valeur de la tva quand on fait un tour de //boucle foreach
        $commandes['tva']['%' . $produit->getTva()->getValeur()] += round($prixTTC - $prixHT, 2);
      }
      $totalTVA += round($prixTTC - $prixHT, 2);
      //A l’interieur du tab $commande  on va créer une série de produit et l’id du produit
      $commandes['produit'][$produit->getId()] = array('reference' => $produit->getNom(),
          'quantite' => $panier[$produit->getId()],
          'prixHT' => round($produit->getPrixht(), 2),
          'prixTTC' => round($produit->getPrixht() / $produit->getTva()->getMultiplicateur(), 2));
      }  
      //infos sur la livraison
      $commandes['livraison'] = array('prenom' => $userAdresseLiv->getPrenom(),
          'nom' => $userAdresseLiv->getNom(),
          'telephone' => $userAdresseLiv->getTelephone(),
          'adresse' => $userAdresseLiv->getAdresse(),
          'cp' => $userAdresseLiv->getCp(),
          'ville' => $userAdresseLiv->getVille(),
          'pays' => $userAdresseLiv->getPays(),
          'complements' => $userAdresseLiv->getComplements());
        //pour facturation
      $commandes['facturation'] = array('prenom' => $userAdresseFact->getPrenom(),
          'nom' => $userAdresseFact->getNom(),
          'telephone' => $userAdresseFact->getTelephone(),
          'adresse' => $userAdresseFact->getAdresse(),
          'cp' => $userAdresseFact->getCp(),
          'ville' => $userAdresseFact->getVille(),
          'pays' => $userAdresseFact->getPays(),
          'complements' => $userAdresseFact->getComplements());
      //stocker le prix ht, ttc et le token
      $commandes['prixHT'] = round($totalHT, 2);

      $commandes['prixTTC'] = round($totalHT + $totalTVA, 2);
      // 20 est la longeur de la chaine de notre token, choix de l'encodage bin2hex
      $commandes['token'] = $tokenGenerer; //bin2hex($tokenGenerer->nextBytes(20));
      //puis retour le tab commande
    return $commandes;
  }

  /**
  * Cette methode remplace l'api banque.
  * @Route("/banque-validation/{id}", name="panier_api_banque")
  */

  public function validationCommande($id, Reference $reference)
  { 
      $commande = $this->getDoctrine()->getRepository(Commandes::class)->find($id);
      if (!$commande || $commande->getValidation() == 1){
        throw $this->createNotFoundException('La commande n\'existe pas');
      }
      $commande->setValidation(1);
      $commande->setReference($reference->addReference()); //Service $reference->getReference()
      $this->manager->flush();   
      $this->session->remove('adresse');
      $this->session->remove('panier');
      $this->session->remove('commande');
      
      $this->addFlash('success','Votre commande est validé avec succès');
      return $this->redirectToRoute('produits_produits');
  }

}

