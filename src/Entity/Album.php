<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Artist", inversedBy="albums")
     */
    private $artist_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $album_title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $album_cover;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $album_description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Song", mappedBy="album_id", orphanRemoval=true)
     */
    private $songs;

    public function __construct()
    {
        $this->artist_id = new ArrayCollection();
        $this->songs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Artist[]
     */
    public function getArtistId(): Collection
    {
        return $this->artist_id;
    }

    public function addArtistId(Artist $artistId): self
    {
        if (!$this->artist_id->contains($artistId)) {
            $this->artist_id[] = $artistId;
        }

        return $this;
    }

    public function removeArtistId(Artist $artistId): self
    {
        if ($this->artist_id->contains($artistId)) {
            $this->artist_id->removeElement($artistId);
        }

        return $this;
    }

    public function getAlbumTitle(): ?string
    {
        return $this->album_title;
    }

    public function setAlbumTitle(string $album_title): self
    {
        $this->album_title = $album_title;

        return $this;
    }

    public function getAlbumCover(): ?string
    {
        return $this->album_cover;
    }

    public function setAlbumCover(string $album_cover): self
    {
        $this->album_cover = $album_cover;

        return $this;
    }

    public function getAlbumDescription(): ?string
    {
        return $this->album_description;
    }

    public function setAlbumDescription(?string $album_description): self
    {
        $this->album_description = $album_description;

        return $this;
    }

    /**
     * @return Collection|Song[]
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setAlbumId($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->contains($song)) {
            $this->songs->removeElement($song);
            // set the owning side to null (unless already changed)
            if ($song->getAlbumId() === $this) {
                $song->setAlbumId(null);
            }
        }

        return $this;
    }
}
