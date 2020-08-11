<?php 
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MontantTvaExtension  extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('montantTva', [$this, 'montantTva']),
        ];
    }
    public function montantTva($prixHt,$tva)
    {
        return round((($prixHt / $tva) - $prixHt),2);
    }

 
}
