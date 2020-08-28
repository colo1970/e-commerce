<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Commandes;
use App\Services\GenerePdf;
use Symfony\Component\HttpFoundation\Response;
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

     /**
     * @Route("/user/facture/{id}", name="user_facture_pdf")
     */
    public function facturePdf($id, GenerePdf $generePdf)
    {
         $facture = $this->getDoctrine()->getRepository(Commandes::class)->findOneBy([
            'user' => $this->getUser(),
            'validation' => 1,
            'id' => $id
        ]);
        return new Response($generePdf->generePdf($facture));
    }       
}
