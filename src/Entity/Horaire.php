<?php

namespace App\Entity;

use App\Repository\HoraireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HoraireRepository::class)]
class Horaire extends Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected  $id ;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

  
    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'horaires')]
    private ?Session $session = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heureFin = null;

    #[ORM\Column(length: 10)]
    private ?string $couleurBordure = null;

    #[ORM\Column(length: 7)]
    private ?string $couleurTexte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut ;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin ;

    #[ORM\OneToMany(mappedBy: 'planing', targetEntity: RDV::class)]
    private Collection $rDVs;

    public function __construct()
    {
        $this->rDVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

   

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): self
    {
        $this->session = $session;

        return $this;
    }

     
    public function __toString() {
        return $this->description;
        ;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getCouleurBordure(): ?string
    {
        return $this->couleurBordure;
    }

    public function setCouleurBordure(string $couleurBordure): self
    {
        $this->couleurBordure = $couleurBordure;

        return $this;
    }

    public function getCouleurTexte(): ?string
    {
        return $this->couleurTexte;
    }

    public function setCouleurTexte(string $couleurTexte): self
    {
        $this->couleurTexte = $couleurTexte;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection<int, RDV>
     */
    public function getRDVs(): Collection
    {
        return $this->rDVs;
    }

    public function addRDV(RDV $rDV): self
    {
        if (!$this->rDVs->contains($rDV)) {
            $this->rDVs->add($rDV);
            $rDV->setPlaning($this);
        }

        return $this;
    }

    public function removeRDV(RDV $rDV): self
    {
        if ($this->rDVs->removeElement($rDV)) {
            // set the owning side to null (unless already changed)
            if ($rDV->getPlaning() === $this) {
                $rDV->setPlaning(null);
            }
        }

        return $this;
    }
}
