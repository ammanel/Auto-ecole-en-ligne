<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
class Document extends Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'date')]
    private $dateEtablissement;

    #[ORM\ManyToOne(targetEntity: Apprenant::class, inversedBy: 'documents')]
    private $compte;

    #[ORM\ManyToOne(targetEntity: TypeDocument::class, inversedBy: 'documents')]
    private $typedoc;

    #[ORM\OneToMany(mappedBy: 'idDoc', targetEntity: Rappel::class)]
    private $rappels;

    
    #[ORM\ManyToOne(targetEntity: Rappel::class, inversedBy: 'documents',cascade: array("persist"))]
    #[ORM\GeneratedValue]
    private $Rappelid;

    public function __construct()
    {
        $this->rappels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEtablissement(): ?\DateTimeInterface
    {
        return $this->dateEtablissement;
    }

    public function setDateEtablissement(\DateTimeInterface $dateEtablissement): self
    {
        $this->dateEtablissement = $dateEtablissement;

        return $this;
    }

    public function getCompte(): ?Apprenant
    {
        return $this->compte;
    }

    public function setCompte(?Apprenant $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getTypedoc(): ?TypeDocument
    {
        return $this->typedoc;
    }

    public function setTypedoc(?TypeDocument $typedoc): self
    {
        $this->typedoc = $typedoc;

        return $this;
    }

    /**
     * @return Collection<int, Rappel>
     */
    public function getRappels(): Collection
    {
        return $this->rappels;
    }

    public function addRappel(Rappel $rappel): self
    {
        if (!$this->rappels->contains($rappel)) {
            $this->rappels[] = $rappel;
            $rappel->setIdDoc($this);
        }

        return $this;
    }

    public function removeRappel(Rappel $rappel): self
    {
        if ($this->rappels->removeElement($rappel)) {
            // set the owning side to null (unless already changed)
            if ($rappel->getIdDoc() === $this) {
                $rappel->setIdDoc(null);
            }
        }

        return $this;
    }

    public function getRappelId(): ?Rappel
    {
        return $this->Rappelid;
    }

    public function setRappelId(?Rappel $Rappelid): self
    {
        $this->Rappelid = $Rappelid;

        return $this;
    }
}
