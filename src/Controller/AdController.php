<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher tout les annonces
     * 
     * @Route("/ads", name="ads")
     * @return Response
     */
    public function index(AdRepository $repo)
    {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
            
        ]);
    }

    /**
     * Permet d'afficher une seule annonce
     * 
     * @Route("/ads/{slug}", name="ads_show ")
     * @return response
     */
    public function show($slug, AdRepository $repo){
        $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
    }
}
