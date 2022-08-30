<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeDePayement;

    #[ORM\ManyToOne(targetEntity: Pack::class, inversedBy: 'transactions')]
    private $idPack;

    #[ORM\ManyToOne(targetEntity: ModeDePaiement::class, inversedBy: 'transactions')]
    private $idModePayement;

    #[ORM\ManyToOne(targetEntity: Apprenant::class, inversedBy: 'transactions')]
    private $IdApprenant;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $cours=false;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    private ?Session $idSession = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeDePayement(): ?string
    {
        return $this->typeDePayement;
    }

    public function setTypeDePayement(string $typeDePayement): self
    {
        $this->typeDePayement = $typeDePayement;

        return $this;
    }

    public function getIdPack(): ?Pack
    {
        return $this->idPack;
    }

    public function setIdPack(?Pack $idPack): self
    {
        $this->idPack = $idPack;

        return $this;
    }

    public function getIdModePayement(): ?ModeDePaiement
    {
        return $this->idModePayement;
    }

    public function setIdModePayement(?ModeDePaiement $idModePayement): self
    {
        $this->idModePayement = $idModePayement;

        return $this;
    }

    public function getIdApprenant(): ?Apprenant
    {
        return $this->IdApprenant;
    }

    public function setIdApprenant(?Apprenant $IdApprenant): self
    {
        $this->IdApprenant = $IdApprenant;

        return $this;
    }

    public function isCours(): ?bool
    {
        return $this->cours;
    }

    public function setCours(?bool $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function getIdSession(): ?Session
    {
        return $this->idSession;
    }

    public function setIdSession(?Session $idSession): self
    {
        $this->idSession = $idSession;

        return $this;
    }

  
    
}
