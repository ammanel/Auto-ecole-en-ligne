<?php

namespace App\Entity;

use App\Repository\RappelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RappelRepository::class)]
class Rappel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateExpiration;

    #[ORM\ManyToOne(targetEntity: Document::class, inversedBy: 'rappels')]
    private $idDoc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getIdDoc(): ?Document
    {
        return $this->idDoc;
    }

    public function setIdDoc(?Document $idDoc): self
    {
        $this->idDoc = $idDoc;

        return $this;
    }
}
