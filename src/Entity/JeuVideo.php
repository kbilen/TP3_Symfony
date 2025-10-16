<?php

namespace App\Entity;

use App\Repository\JeuVideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuVideoRepository::class)]
class JeuVideo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $developpeur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateSortie = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?string $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\ManyToOne(inversedBy: 'genre')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editeur $editeur = null;

    #[ORM\ManyToOne]
    private ?Genre $Genre = null;

    #[ORM\ManyToOne(inversedBy: 'jeuVideos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genre $genre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDeveloppeur(): ?string
    {
        return $this->developpeur;
    }

    public function setDeveloppeur(string $developpeur): static
    {
        $this->developpeur = $developpeur;

        return $this;
    }

    public function getDateSortie(): ?\DateTime
    {
        return $this->dateSortie;
    }

    public function setDateSortie(?\DateTime $dateSortie): static
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): static
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->Genre;
    }

    public function setGenre(?Genre $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }
}
