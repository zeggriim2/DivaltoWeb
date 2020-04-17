<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChampionsController extends AbstractController
{
    /**
     * @Route("/champions", name="champions")
     */
    public function index(ChampionRepository $repo)
    {
        $champions = $repo->findAll();
        
        return $this->render('champions/index.html.twig', [
            'champions' => $champions,
        ]);
    }
}
