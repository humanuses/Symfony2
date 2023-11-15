<?php

namespace App\Entity;

use App\Repository\MagazynRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MagazynRepository::class)]
class Magazyn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nazwa_Magazynu = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Przypisane_Magazyny')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'magazyn', targetEntity: Zasoby::class)]
    private Collection $zasobies;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->zasobies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaMagazynu(): ?string
    {
        return $this->Nazwa_Magazynu;
    }

    public function setNazwaMagazynu(string $Nazwa_Magazynu): self
    {
        $this->Nazwa_Magazynu = $Nazwa_Magazynu;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addPrzypisaneMagazyny($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removePrzypisaneMagazyny($this);
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
            $zasoby->setMagazyn($this);
        }

        return $this;
    }

    public function removeZasoby(Zasoby $zasoby): self
    {
        if ($this->zasobies->removeElement($zasoby)) {
            // set the owning side to null (unless already changed)
            if ($zasoby->getMagazyn() === $this) {
                $zasoby->setMagazyn(null);
            }
        }

        return $this;
    }
}
