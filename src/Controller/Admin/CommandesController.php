<?php

namespace App\Controller\Admin;

use App\Entity\Commandes;
use App\Services\GenerePdf;
use App\Repository\CommandesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/commandes")
*/
class CommandesController extends AbstractController
{
    /**
     * @Route("/", name="admin_commandes_index", methods={"GET"})
    */
    public function index(CommandesRepository $commandesRepository): Response
    {
        return $this->render('admin/commandes/index.html.twig', [
            'commandes' => $commandesRepository->findAll(),
        ]);
    } 

    /**
     * @Route("/{id}", name="admin_commandes_show", methods={"GET"})
     */
    public function show(Commandes $commande, GenerePdf $generePdf): Response
    {
        return new Response($generePdf->generePdf($commande));
    }

}
