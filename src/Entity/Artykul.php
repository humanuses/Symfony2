<?php

namespace App\Entity;

use App\Repository\ArtykulRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtykulRepository::class)]
class Artykul
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nazwa_artykulu = null;

    #[ORM\ManyToOne(inversedBy: 'artykuls')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jednostka $Jednostka_Rozliczenia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNawzaArtykulu(): ?string
    {
        return $this->Nazwa_artykulu;
    }

    public function setNawzaArtykulu(string $Nawza_artykulu): self
    {
        $this->Nazwa_artykulu = $Nawza_artykulu;

        return $this;
    }

    public function getJednostkaRozliczenia(): ?Jednostka
    {
        return $this->Jednostka_Rozliczenia;
    }

    public function setJednostkaRozliczenia(?Jednostka $Jednostka_Rozliczenia): self
    {
        $this->Jednostka_Rozliczenia = $Jednostka_Rozliczenia;

        return $this;
    }
}
