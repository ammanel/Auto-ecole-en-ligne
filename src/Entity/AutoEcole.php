<?php

namespace App\Entity;

use App\Repository\AutoEcoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AutoEcoleRepository::class)]
class AutoEcole extends Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'text')]
    private $Description;

    #[ORM\Column(type: 'float')]
    private $Note;

    #[ORM\Column(type: 'string')]
    private $Horaire_debut;

    #[ORM\Column(type: 'string')]
    private $Horaire_fin;

    

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->Note;
    }

    public function setNote(float $Note): self
    {
        $this->Note = $Note;

        return $this;
    }

    public function getHoraireDebut(): ?string
    {
        return $this->Horaire_debut;
    }

    public function setHoraireDebut(string $Horaire): self
    {
        $this->Horaire_debut = $Horaire;

        return $this;
    }


    public function getHoraireFin(): ?string
    {
        return $this->Horaire_fin;
    }

    public function setHoraireFin(string $Horaire): self
    {
        $this->Horaire_fin = $Horaire;

        return $this;
    }

   

  
}
