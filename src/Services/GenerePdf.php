<?php
namespace App\Services;

use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerePdf
{
    private $twig;

    public function __construct(Environment $twig)
    {
       $this->twig = $twig;
    }
    public function generePdf($facture)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html = $this->twig->render('facture/facture_pdf.html.twig', [
            'facture' => $facture,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        return $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
 
    }
}