<?php

namespace App\Controller;

use App\Entity\Pages;
use App\Repository\PagesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /**
     * @Route("/pages", name="pages_menus_foot")
     */
    public function menusFoot(PagesRepository $pagesRepo)
    {
        return $this->render('pages/menu_foot.html.twig', [
            'pages' => $pagesRepo->findAll(),
        ]);
    }
      /**
     * @Route("/quisommesnous/{id}", name="pages_menus_qui_s_n")
     */
    public function menusFootQui(Pages $page)
    {
        return $this->render('pages/menu_qui_s_n.html.twig', [
            'page' => $page,
        ]);
    }
}
