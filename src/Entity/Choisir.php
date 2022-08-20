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

    #[ORM\ManyToOne(targetEntity: AutoEcole::class)]
    
    private $idEcole;

    #[ORM\ManyToOne(targetEntity: Apprenant::class)]
    private $idApprenant;

    #[ORM\Column(type: 'date')]
    private $dateInscription;

    #[ORM\Column(type: 'boolean')]
    private $satut=0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEcole(): ?AutoEcole
    {
        return $this->idEcole;
    }

    public function setIdEcole(?AutoEcole $idEcole): self
    {
        $this->idEcole = $idEcole;

        return $this;
    }

    public function getIdApprenant(): ?Apprenant
    {
        return $this->idApprenant;
    }

    public function setIdApprenant(?Apprenant $idApprenant): self
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
