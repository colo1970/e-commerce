<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserRolesType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
* Require ROLE_ADMIN for *every* controller method in this class.
* @IsGranted("ROLE_ADMIN")
*/
class RolesController extends AbstractController
{
    /**
     * @Route("/admin/roles", name="admin_roles")
    */
    public function index(UserRepository $userRepo)
    {
        return $this->render('admin/roles/index.html.twig', [
            'users' => $userRepo->findAll(),
        ]);
    }

    /**
     * @Route("/admin/roles/{id}", name="admin_roles_edit")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(UserRolesType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush($user);
            $this->addFlash('success','Le rôle a été bien modifié');
            return $this->redirectToRoute('admin_roles');
        }
        return $this->render('admin/roles/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
