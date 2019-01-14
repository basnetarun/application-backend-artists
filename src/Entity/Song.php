<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SongRepository")
 */
class Song
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $album_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Artist", inversedBy="songs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artist_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $song_title;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $song_length;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlbumId(): ?Album
    {
        return $this->album_id;
    }

    public function setAlbumId(?Album $album_id): self
    {
        $this->album_id = $album_id;

        return $this;
    }

    public function getArtistId(): ?Artist
    {
        return $this->artist_id;
    }

    public function setArtistId(?Artist $artist_id): self
    {
        $this->artist_id = $artist_id;

        return $this;
    }

    public function getSongTitle(): ?string
    {
        return $this->song_title;
    }

    public function setSongTitle(string $song_title): self
    {
        $this->song_title = $song_title;

        return $this;
    }

    public function getSongLength(): ?string
    {
        return $this->song_length;
    }

    public function setSongLength(string $song_length): self
    {
        $this->song_length = $song_length;

        return $this;
    }
}
