<?php

namespace App\Entity;

use App\Repository\JednostkaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JednostkaRepository::class)]
class Jednostka
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nazwa_Jednostki = null;

    #[ORM\OneToMany(mappedBy: 'Jednostka_Rozliczenia', targetEntity: Artykul::class)]
    private Collection $artykuls;

    #[ORM\OneToMany(mappedBy: 'Jednostka_Miary', targetEntity: Zasoby::class)]
    private Collection $zasobies;

    public function __construct()
    {
        $this->artykuls = new ArrayCollection();
        $this->zasobies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaJednostki(): ?string
    {
        return $this->Nazwa_Jednostki;
    }

    public function setNazwaJednostki(string $Nazwa_Jednostki): self
    {
        $this->Nazwa_Jednostki = $Nazwa_Jednostki;

        return $this;
    }

    /**
     * @return Collection<int, Artykul>
     */
    public function getArtykuls(): Collection
    {
        return $this->artykuls;
    }

    public function addArtykul(Artykul $artykul): self
    {
        if (!$this->artykuls->contains($artykul)) {
            $this->artykuls->add($artykul);
            $artykul->setJednostkaRozliczenia($this);
        }

        return $this;
    }

    public function removeArtykul(Artykul $artykul): self
    {
        if ($this->artykuls->removeElement($artykul)) {
            // set the owning side to null (unless already changed)
            if ($artykul->getJednostkaRozliczenia() === $this) {
                $artykul->setJednostkaRozliczenia(null);
            }
        }

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
            $zasoby->setJednostkaMiary($this);
        }

        return $this;
    }

    public function removeZasoby(Zasoby $zasoby): self
    {
        if ($this->zasobies->removeElement($zasoby)) {
            // set the owning side to null (unless already changed)
            if ($zasoby->getJednostkaMiary() === $this) {
                $zasoby->setJednostkaMiary(null);
            }
        }

        return $this;
    }
}
