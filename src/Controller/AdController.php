<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * Permet d'afficher tout les annonces
     * 
     * @Route("/ads", name="ads_index")
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
     * permet de creé une annonce
     *
     * @Route("/ads/new", name="ads_create")
     * @return response
     */
    public function create(Request $request, EntityManagerInterface $manager){
        $ad = new Ad();


        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        // Test si le formulaire a été soumis et a été valide.
        if ($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée."
            );
            

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /**
     * Permet d'afficher une seule annonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * @return response
     */
    public function show( Ad $ad){
        // Je récupere l'annonce qui correspond au slug
        // $ad = $repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
    }
}
