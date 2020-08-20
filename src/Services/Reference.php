<?php
namespace App\Services;

use App\Repository\CommandesRepository;

class Reference
{
    private $commandeRepository;
    public function __construct(CommandesRepository $commandeRepository)
    {
       $this->commandeRepository = $commandeRepository;
    }
    public function addReference()
    {
        $commande = $this->commandeRepository->findOneBy([
            'validation' => 1], ['id' => 'DESC']);
        if(!$commande){
            return 1;
        }
      return $commande->getReference()+1;
    }
}