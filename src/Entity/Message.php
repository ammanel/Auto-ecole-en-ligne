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

    #[ORM\ManyToOne(targetEntity: Personne::class)]
    private $EnvoyerPar;

    #[ORM\ManyToOne(targetEntity: Personne::class)]
    private $RecuPar;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $DateEnvoi;

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

    public function setEnvoyerPar(?Personne $send): self
    {
        $this->EnvoyerPar = $send;

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

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi(?\DateTimeInterface $DateEnvoi): self
    {
        $this->DateEnvoi = $DateEnvoi;

        return $this;
    }
}
