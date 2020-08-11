<?php 
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CalculTtcProduitExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('calculTtcProduit', [$this, 'calculTtcProduit']),
        ];
    }
    /*
    *doit obligatoirement avoir un parametre, ce que nous filtrons prixht
    *Calcul Ttc d'un produit
    */
    public function calculTtcProduit($prixHT,$mutiplicateur){
        return round($prixHT/$mutiplicateur,2);
    }
 
}
