<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController
{
    /**
     * @Route("/artist", name="artist"), methods={"GET","HEAD"}
     */
    public function index()
    {
        return $this->render('artist/index.html.twig', [
            'controller_name' => 'ArtistController',
        ]);
    }
}
