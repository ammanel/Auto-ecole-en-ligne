<?php

namespace App\Entity;

use App\Repository\RappelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'Rappel_id', targetEntity: Document::class)]
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setRappelId($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getRappelId() === $this) {
                $document->setRappelId(null);
            }
        }

        return $this;
    }
}
