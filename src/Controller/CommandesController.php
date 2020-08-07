<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandesController extends AbstractController
{   
    /**
     * @Route("/facture", name="commandes_facture")
    */
    public function facture()
    {
        return $this->render('commandes/facture.html.twig');
    }

   
}
