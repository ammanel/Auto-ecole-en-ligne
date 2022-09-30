<?php

namespace App\Entity;

use App\Repository\RDVRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RDVRepository::class)]
class RDV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rDVs')]
    private ?Horaire $planing = null;

    #[ORM\ManyToOne(inversedBy: 'rDVs')]
    private ?Choisir $choix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateJour ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaning(): ?Horaire
    {
        return $this->planing;
    }

    public function setPlaning(?Horaire $planing): self
    {
        $this->planing = $planing;

        return $this;
    }

    public function getChoix(): ?Choisir
    {
        return $this->choix;
    }

    public function setChoix(?Choisir $choix): self
    {
        $this->choix = $choix;

        return $this;
    }

    public function getDateJour(): ?\DateTimeInterface
    {
        return $this->dateJour;
    }

    public function setDateJour(\DateTimeInterface $dateJour): self
    {
        $this->dateJour = $dateJour;

        return $this;
    }
}
