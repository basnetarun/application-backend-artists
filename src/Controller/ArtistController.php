<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Serializer\Serializer;

use FOS\RestBundle\Controller\Annotations as Rest;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArtistController extends FOSRestController implements ClassResourceInterface
{
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /** 
     * @var ArtistRepository
     */
    private $artistRepository;


    
    public function __construct(
        EntityManagerInterface $entityManager,
        ArtistRepository $artistRepository
    ) {
        $this->entityManager    = $entityManager;
        $this->artistRepository = $artistRepository;

    }
    
    /**
     * Retrieves a collection of Artist resource
     * @Rest\Get("/artists.{ext}")
     * @return Artist|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    */
    public function getArtists()
    {
        
        $artists = $this->artistRepository->findAll();

        if(null == $artists):
            throw new NotFoundHttpException('Es sind zurzeit keine Artisten in Datenbank vorhanden.');
        endif;
       
        return $this->view(
            [   
                'data' => new Serializer($artists),
                'status' => Response::HTTP_OK
            ]
        );

    }

    /** 
     * Retrieves a single Artist resource
     * @Rest\Get(
     *      "/artist/{artistId}.{ext}"
     * )
     * @return Artist|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function getArtist(int $artistId)
    {
        $artist = $this->artistRepository->findById($artistId);

        if(null == $artist):
            throw new NotFoundHttpException('Es wurden keinen Artist mit der ID '.$artistId.' gefunden.');
        endif;

        return $this->view(
            [   
                $artist,
                'status' => Response::HTTP_OK
            ]
        );
    }


}
