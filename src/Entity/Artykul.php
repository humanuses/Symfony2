<?php

namespace App\Entity;

use App\Repository\ArtykulRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'Nazwa_Artykulu', targetEntity: Zasoby::class)]
    private Collection $zasobies;

    public function __construct()
    {
        $this->zasobies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaArtykulu(): ?string
    {
        return $this->Nazwa_artykulu;
    }

    public function setNazwaArtykulu(string $Nazwa_artykulu): self
    {
        $this->Nazwa_artykulu = $Nazwa_artykulu;

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

    /**
     * @return Collection<int, Zasoby>
     */
    public function getZasobies(): Collection
    {
        return $this->zasobies;
    }

    public function addZasoby(Zasoby $zasoby): self
    {
        if (!$this->zasobies->contains($zasoby)) {
            $this->zasobies->add($zasoby);
            $zasoby->setNazwaArtykulu($this);
        }

        return $this;
    }

    public function removeZasoby(Zasoby $zasoby): self
    {
        if ($this->zasobies->removeElement($zasoby)) {
            // set the owning side to null (unless already changed)
            if ($zasoby->getNazwaArtykulu() === $this) {
                $zasoby->setNazwaArtykulu(null);
            }
        }

        return $this;
    }
}
