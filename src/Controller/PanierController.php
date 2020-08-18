<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\UserAdresses;
use App\Form\UserAdresseType;
use App\Repository\ProduitsRepository;
use App\Repository\UserAdressesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
  private $session;
  public function  __construct(SessionInterface $session)
  {
     $this->session = $session;
  }

    /**
   * @Route("/panier", name="panier_index")
   */
  public function panier(ProduitsRepository $produitsRepo)
  {
    $panier = $this->session->get('panier', []) ;
    $produits = $produitsRepo->findByIdPanier((array_keys($panier)));
    return $this->render('panier/panier.html.twig', [
          'produits'=>$produits,
          'panier'=>$panier,
      ]);
  }

      /**
   * @Route("/panier/{id}", name="panier_ajout")
   */
  public function addPanier(Request $request, Produits $produit)
  {
      $panier  = $this->session->get('panier', []);
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

      $this->session->set('panier', $panier);
      return $this->redirectToRoute("panier_index");
  }

  /**
 * @Route("/supprimer/{id}", name="panier_prod_sup")
 */
public function supPanier(Produits $produit)
{ 
  $panier  = $this->session->get('panier', []);
  $id = $produit->getId();
  if (array_key_exists($id, $panier)) {
      unset($panier[$id]);
      $this->addFlash('success', 'Produit supprimé');
    } 
    $session->set('panier', $panier);
    return $this->redirectToRoute("panier_index");
}
  /**
   * @Route("/quantite-dans-panier", name="panier_quantite_dans_panier")
   */
  public function nombreProduitsPanier()
  {
    $panier = $this->session->get('panier', []) ;
    return $this->render('_menus/_quantite_dans_panier.html.twig', [
        'nbProduitsPanier'=>count($panier)
    ]);
  }

  /**
   * @Route("/livraison", name="panier_livraison")
   */
  public function livraison(Request $request)
  {
    $user = $this->getUser();
    $userAdresse = new UserAdresses();
    $form = $this->createForm(UserAdresseType::class, $userAdresse);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid() ){ 
      $manager = $this->getDoctrine()->getManager();
      //ajouter l’id de l’utilisateurs dans la table UtilisateursAdresses
      $userAdresse->setUser($user);
      $manager->persist($userAdresse);
      $manager->flush();
      return $this->redirectToRoute('panier_livraison');
    }
    return $this->render('livraison/livraison.html.twig', [
       'form'=>$form->createView(),
       'user' =>$user
    ]);
  }
  /**
   * @Route("/sup-livraion-adresse/{id}", name="supprimeLivraisonAdresse")
   */
  public function supprimeLivraisonAdresse(UserAdresses $userAdresse)
  {
    if($this->getUser()->getEmail() === $userAdresse->getUser()->getEmail()){
      $manager = $this->getDoctrine()->getManager();
      $manager->remove($userAdresse);
      $manager->flush();
      $this->addFlash('messages','Cette adresse a été bien supprimé');
      return $this->redirectToRoute('panier_livraison');
    }
  }
  
/* Cette methode stocke dans un tableau $adresse[]  l'adresse de livraison et de facturation
    *va etre appeler dans validationAction ()
   */
  public function setLivraisonOnSession(Request $request) 
  {
      $idAdresses = $this->session->get('idAdresses', []);
      if($request->request->get('livraison')!= null &&  $request->request->get('facturation') !=null ){
        $idAdresses['livraison']= $request->request->get('livraison');
        $idAdresses['facturation']= $request->request->get('facturation');
      } 
      else {
         return $this->redirectToRoute('panier_valide_adresse');
      }

      $this->session->set('idAdresses', $idAdresses);
      return $this->redirectToRoute('panier_valide_adresse');
}


  /**
   * @Route("/valide-adresse", name="panier_valide_adresse")
   */
  public function validAdresse(Request $request, UserAdressesRepository $userAdresseRepo, ProduitsRepository $produitsRepo)
  {
    if($request->isMethod('post')){
        $this->setLivraisonOnSession($request);
        $idAdresses = $this->session->get('idAdresses', []);
        $userAdresseLiv= $userAdresseRepo->find($idAdresses['livraison']);
        $userAdresseFact= $userAdresseRepo->find($idAdresses['facturation']);
        $panier = $this->session->get('panier', []);
        $produits = $produitsRepo->findByIdPanier(array_keys($panier));
        return $this->render('validation/validation.html.twig',[
          'livraison'=>$userAdresseLiv,
          'facturation'=>$userAdresseFact,
          'produits'=>$produits,
          'panier'=>$panier
        ]);
    }
  }

  /**
   * @Route("/valide-paye", name="panier_valide_paye")
   */
  public function validationAction() {
    
    $adresses = $this->session->get('idAdresses',[]);
    return $this->render('validation/validation.html.twig');
  }
}
