<?php

namespace App\Entity;

use App\Repository\StawkivatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StawkivatRepository::class)]
class Stawkivat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $stawkavat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStawkavat(): ?int
    {
        return $this->stawkavat;
    }

    public function setStawkavat(int $stawkavat): self
    {
        $this->stawkavat = $stawkavat;

        return $this;
    }
}
