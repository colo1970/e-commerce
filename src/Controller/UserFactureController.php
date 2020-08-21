<?php

namespace App\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
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

     /**
     * @Route("/user/facture/{id}", name="user_facture_pdf")
     */
    public function facturePdf($id)
    {
        
        $facture = $this->getDoctrine()->getRepository(Commandes::class)->findOneBy([
            'user' => $this->getUser(),
            'validation' => 1,
            'id' => $id
        ]);
        //dd($facture);
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('facture/facture_pdf.html.twig', [
            'facture' => $facture,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
        
}
