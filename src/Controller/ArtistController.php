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
        
        if(null == $artists) {
            throw new NotFoundHttpException('Es sind zurzeit keine Artisten in Datenbank vorhanden.');
        }
        
        $result = array();
        foreach($artists as $artist) {
            array_push($result, $this->getArtistData($artist));
            
        }
        
        return $this->view(
            [   
                'data' => $result,
                'status' => Response::HTTP_OK
            ]
        );

    }

    /** 
     * Retrieves a single Artist resource
     * @Rest\Get(
     *      "/artist/{artistToken}.{ext}"
     * )
     * @return Artist|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function getArtist(string $artistToken)
    {
        $artist = $this->artistRepository->findOneBy(['artist_token' => $artistToken]);
        

        if(null == $artist) {
            throw new NotFoundHttpException('Es wurden keinen Artist mit der ID '.$artistId.' gefunden.');
        }
        $result = array();
        array_push($result, $this->getArtistData($artist));
        return $this->view(
            [   
                'data' => $result,
                'status' => Response::HTTP_OK
            ]
        );
    }


    /**
     * Sets Artists as Array with onyl the required fields
     * @return Collection|Artist[]
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

     private function getArtistData(\App\Entity\Artist $obj) 
     {
        $artistData = array(); 
        
        if($obj != null) {
            
            $artistData['token']    = $obj->getArtistToken();
            $artistData['name']     = $obj->getArtistName();
            
            $albums = $obj->getAlbums();
            if($albums != null) {
                foreach($albums as $album) {
                    $artistData['albums'][] = array(
                        'token'       => $album->getAlbumToken(),
                        'album_title' => $album->getAlbumTitle(),
                        'album_cover' => $album->getAlbumCover()

                    );
                }
            }
        }

        return $artistData;
     }


}
