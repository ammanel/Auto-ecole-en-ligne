<?php

namespace App\Entity;

use App\Repository\AutoEcoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $Horairedebut;

    #[ORM\Column(type: 'string')]
    private $Horairefin;

    #[ORM\OneToMany(mappedBy: 'createur', targetEntity: Rapport::class)]
    private $rapports;

    #[ORM\ManyToMany(targetEntity: Apprenant::class, mappedBy: 'idAutoEcolr')]
    private $apprenants;

    #[ORM\OneToMany(mappedBy: 'autoEcole', targetEntity: Session::class)]
    private Collection $session;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->session = new ArrayCollection();
    }

    

    

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
        return $this->Horairedebut;
    }

    public function setHoraireDebut(string $Horaire): self
    {
        $this->Horairedebut = $Horaire;

        return $this;
    }


    public function getHoraireFin(): ?string
    {
        return $this->Horairefin;
    }

    public function setHoraireFin(string $Horaire): self
    {
        $this->Horairefin = $Horaire;

        return $this;
    }

    /**
     * @return Collection<int, Rapport>
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setCreateur($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->removeElement($rapport)) {
            // set the owning side to null (unless already changed)
            if ($rapport->getCreateur() === $this) {
                $rapport->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Apprenant>
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->addIdAutoEcolr($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            $apprenant->removeIdAutoEcolr($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): self
    {
        if (!$this->session->contains($session)) {
            $this->session->add($session);
            $session->setAutoEcole($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->session->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getAutoEcole() === $this) {
                $session->setAutoEcole(null);
            }
        }

        return $this;
    }

   
    
    
   
  
}
