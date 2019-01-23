<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Serializer\Serializer;

use FOS\RestBundle\Controller\Annotations as Rest;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\AlbumRepository;
use App\Entity\Artist;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AlbumController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /** 
     * @var AlbumRepository
     */
    private $albumRepository;


    
    public function __construct(
        EntityManagerInterface $entityManager,
        AlbumRepository $albumRepository
    ) {
        $this->entityManager    = $entityManager;
        $this->albumRepository = $albumRepository;

    }
    
    /**
     * Retrieves a collection of Album resources
     * @Rest\Get("/albums.{ext}")
     * @return Album|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
    */
    public function getAlbums()
    {
        
        $albums = $this->albumRepository->findAll();
        
        if(null == $albums) {
            throw new NotFoundHttpException('Es sind zurzeit keine Alben in Datenbank vorhanden.');
        }
        
        $result = array();
        foreach($albums as $album) {
            array_push($result, $this->getAlbumData($album));
            
        }
        
        return $this->view(
            [   
                'data' => $result,
                'status' => Response::HTTP_OK
            ]
        );

    }

    /** 
     * Retrieves a single Album resource
     * @Rest\Get(
     *      "/album/{albumToken}.{ext}"
     * )
     * @return Album|null
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

    public function getAlbum(string $albumToken)
    {
        $album = $this->albumRepository->findOneBy(['album_token' => $albumToken]);
        

        if(null == $album) {
            throw new NotFoundHttpException('Es wurden kein Album mit dem Token '.$albumToken.' gefunden.');
        }
        $result = array();
        array_push($result, $this->getAlbumData($album));
        return $this->view(
            [   
                'data' => $result,
                'status' => Response::HTTP_OK
            ]
        );
    }


    /**
     * Sets Albumss as Array with onyl the required fields
     * @return Collection|Album[]
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */

     private function getAlbumData(\App\Entity\Album $obj) 
     {
        $albumData = array(); 
        
        if($obj != null) {
            
            $albumData['token']    = $obj->getAlbumToken();
            $albumData['name']     = $obj->getAlbumTitle();

            $artistArr = $obj->getArtistId()->toArray();

            $albumData['artist']['token']     = $artistArr[0]->getArtistToken();
            $albumData['artist']['name']    = $artistArr[0]->getArtistName();
         

            
            $songs = $obj->getSongs();
            if($songs != null) {
                foreach($songs as $song) {
                    $albumData['songs'][] = array(
                        
                        'title'    => $song->getSongTitle(),
                        'length'   => $song->getSongLength()

                    );
                }
            }
        }

        return $albumData;
     }



}
