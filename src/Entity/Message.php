<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Contenu;

    #[ORM\ManyToOne(targetEntity: Personne::class, inversedBy: 'EnvoyerPar')]
    private $EnvoyerPar;

    #[ORM\ManyToOne(targetEntity: Personne::class, inversedBy: 'RecuPar')]
    private $RecuPar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getEnvoyerPar(): ?Personne
    {
        return $this->EnvoyerPar;
    }

    public function setEnvoyerPar(?Personne $EnvoyerPar): self
    {
        $this->EnvoyerPar = $EnvoyerPar;

        return $this;
    }

    public function getRecuPar(): ?Personne
    {
        return $this->RecuPar;
    }

    public function setRecuPar(?Personne $RecuPar): self
    {
        $this->RecuPar = $RecuPar;

        return $this;
    }
}
