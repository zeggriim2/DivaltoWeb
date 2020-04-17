<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends Controller{

    /**
     * Undocumented function
     * @Route("/", name="homepage")
     * @return void
     */
    public function home(){
        return $this->render('base.html.twig');
    }
} 