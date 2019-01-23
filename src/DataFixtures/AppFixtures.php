<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;

use App\Utils\TokenGenerator;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // read given json url and convert to array 
		
		$dataUrl = file_get_contents('https://gist.githubusercontent.com/fightbulc/9b8df4e22c2da963cf8ccf96422437fe/raw/8d61579f7d0b32ba128ffbf1481e03f4f6722e17/artist-albums.json');
		$data = json_decode($dataUrl, true);
		
		
		if(is_array($data) && !empty($data)):
		foreach ($data as $artist):
			
			
			
			
			// generate a token for artist 
				
			$artist['token'] = TokenGenerator::generate(6);
			
			
			$artistObj = new Artist();
			// set name and token for the artist
			$artistObj->setArtistName($artist['name']);
			$artistObj->setArtistToken($artist['token']);
			
			// save artist and check for albums rightafter
			$manager->persist($artistObj);
			$manager->flush();
			
			if(is_array($artist['albums']) && !empty($artist['albums'])):
				foreach($artist['albums'] as $album):
					
					$album['token'] = TokenGenerator::generate(6);
					
					$albumObj = new Album();
					
					
					$albumObj->setAlbumToken($album['token']);
					$albumObj->setAlbumTitle($album['title']);
					$albumObj->setAlbumCover($album['cover']);
                    $albumObj->setAlbumDescription($album['description']);
                    
                    // set relation with artist
                    $albumObj->addArtistId($artistObj);
					
					// save album, then check for songs rightafter
					$manager->persist($albumObj);
					$manager->flush();
					
					if(is_array($album['songs']) && !empty($album['songs'])):
						foreach ($album['songs'] as $song):
						
							$songObj = new Song();
                            
                            // set relation with artist and album
                            $songObj->setAlbumId($albumObj);
                            $songObj->setArtistId($artistObj);

							$songObj->setSongTitle($song['title']);
							
							$lengthArray = explode(':', $song['length']);
							$lengthSeconds = ($lengthArray[0]*60) + $lengthArray[1];
							
							$songObj->setSongLength($lengthSeconds);
							// save song
							$manager->persist($songObj);
							$manager->flush();
						
						endforeach;
					endif;
					
					
				endforeach; 
						
			
			endif;
		endforeach;
        endif;
        
        $manager->flush();
        return;
    }
}
