<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController {

    /**
     * Undocumented function
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function home(Request $request){

        $routeName =  $request->attributes->all();
        $this->generateUrl('homepage', []);
        dump($routeName);
        return $this->render('base.html.twig');
    }
} 