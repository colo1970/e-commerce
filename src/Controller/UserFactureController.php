<?php

namespace App\Controller;

use App\Entity\Commandes;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserFactureController extends AbstractController
{
    /**
     * @Route("/user/facture", name="user_facture")
     */
    public function facture()
    {
        $factures = $this->getDoctrine()->getRepository(Commandes::class)->findCommandeByUser($this->getUser());
        return $this->render('facture/facture.html.twig', [
            'factures' => $factures,
        ]);
    }
}
