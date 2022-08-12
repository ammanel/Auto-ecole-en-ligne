<?php

namespace App\Entity;

use App\Repository\ChoisirRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChoisirRepository::class)]
class Choisir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $idEcole;

    #[ORM\Column(type: 'integer')]
    private $idApprenant;

    #[ORM\Column(type: 'date')]
    private $dateInscription;

    #[ORM\Column(type: 'boolean')]
    private $satut=0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEcole(): ?int
    {
        return $this->idEcole;
    }

    public function setIdEcole(int $idEcole): self
    {
        $this->idEcole = $idEcole;

        return $this;
    }

    public function getIdApprenant(): ?int
    {
        return $this->idApprenant;
    }

    public function setIdApprenant(int $idApprenant): self
    {
        $this->idApprenant = $idApprenant;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function isSatut(): ?bool
    {
        return $this->satut;
    }

    public function setSatut(bool $satut): self
    {
        $this->satut = $satut;

        return $this;
    }
}
