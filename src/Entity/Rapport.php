<?php

namespace App\Entity;

use App\Repository\RapportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RapportRepository::class)]
class Rapport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateCrea;

    #[ORM\Column(type: 'time')]
    private $timeCrea;

    #[ORM\Column(type: 'text')]
    private $contenu=' ';

    #[ORM\ManyToOne(targetEntity: AutoEcole::class, inversedBy: 'rapports')]
    private $createur;

    #[ORM\ManyToOne(inversedBy: 'rapports')]
    private ?Apprenant $apRapport = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(\DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    public function getTimeCrea(): ?\DateTimeInterface
    {
        return $this->timeCrea;
    }

    public function setTimeCrea(\DateTimeInterface $timeCrea): self
    {
        $this->timeCrea = $timeCrea;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): ?self
    {
        $this->contenu =(string) $contenu;

        return $this;
    }

    public function getCreateur(): ?AutoEcole
    {
        return $this->createur;
    }
    
    public function setCreateur(?AutoEcole $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getApRapport(): ?Apprenant
    {
        return $this->apRapport;
    }

    public function setApRapport(?Apprenant $apRapport): self
    {
        $this->apRapport = $apRapport;

        return $this;
    }
}
