<?php

namespace App\Entity;

use App\Repository\ZasobyRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ZasobyRepository::class)]
#[UniqueEntity(fields: ['Nazwa_Artykulu','magazyn','vat','Cena_Jednostkowa'], message: 'Już isnieje taki artykuł na tym magazynnie')]
class Zasoby
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'zasobies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artykul $Nazwa_Artykulu = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'Nie możesz wydać więcej niż posiadasz na magazynie')]
    private ?float $ilosc = null;

    #[ORM\ManyToOne(inversedBy: 'zasobies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Jednostka $Jednostka_Miary = null;

    #[ORM\Column]
    private ?float $vat = null;

    #[ORM\Column]
    private ?float $Cena_Jednostkowa = null;

    #[ORM\Column]
    private ?float $Wartosc_Podatku = null;

    #[ORM\Column]
    private ?float $Wartosc_Brutto = null;

    #[ORM\ManyToOne(inversedBy: 'zasobies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Magazyn $magazyn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwaArtykulu(): ?Artykul
    {
        return $this->Nazwa_Artykulu;
    }

    public function setNazwaArtykulu(?Artykul $Nazwa_Artykulu): self
    {
        $this->Nazwa_Artykulu = $Nazwa_Artykulu;

        return $this;
    }

    public function getIlosc(): ?float
    {
        return $this->ilosc;
    }

    public function setIlosc(float $ilosc): self
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    public function getJednostkaMiary(): ?Jednostka
    {
        return $this->Jednostka_Miary;
    }

    public function setJednostkaMiary(?Jednostka $Jednostka_Miary): self
    {
        $this->Jednostka_Miary = $Jednostka_Miary;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getCenaJednostkowa(): ?float
    {
        return $this->Cena_Jednostkowa;
    }

    public function setCenaJednostkowa(float $Cena_Jednostkowa): self
    {
        $this->Cena_Jednostkowa = $Cena_Jednostkowa;

        return $this;
    }

    public function getWartoscPodatku(): ?float
    {
        return $this->Wartosc_Podatku;
    }

    public function setWartoscPodatku(float $Wartosc_Podatku): self
    {
        $this->Wartosc_Podatku = $Wartosc_Podatku;

        return $this;
    }

    public function getWartoscBrutto(): ?float
    {
        return $this->Wartosc_Brutto;
    }

    public function setWartoscBrutto(float $Wartosc_Brutto): self
    {
        $this->Wartosc_Brutto = $Wartosc_Brutto;

        return $this;
    }

    public function getMagazyn(): ?Magazyn
    {
        return $this->magazyn;
    }

    public function setMagazyn(?Magazyn $magazyn): self
    {
        $this->magazyn = $magazyn;

        return $this;
    }
}
