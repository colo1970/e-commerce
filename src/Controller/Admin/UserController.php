<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/users/admin")
*/
class UserController extends Controller
{    
    /**
     * @Route("/", name="admin_users_index", methods={"GET"})
    */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        return $this->render('admin/Users/index.html.twig', [
            'users' => $users
        ]);       
    }

    /**
     * @Route("/{id}/adresses", name="admin_adresses_users")
    */
    //liste les adresse du client ainsi que ses factures
    public function adressesFactureUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);       
          return $this->render('admin/users/adresses.html.twig', [
            'user' => $user
        ]);    
    }
    
    /**
     * liste client ainsi que ses factures
     * @Route("/{id}/factures", name="admin_factures_users")
    */
    public function factureUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);       
          return $this->render('admin/users/factures.html.twig', [
            'user' => $user
        ]);    
    }

}
