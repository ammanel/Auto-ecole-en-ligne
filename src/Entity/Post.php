<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post extends Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $Titre;

    #[ORM\Column(type: 'text')]
    private $Contenu;

    #[ORM\ManyToMany(targetEntity: Apprenant::class, inversedBy: 'posts')]
    private $datev;

    public function __construct()
    {
        $this->datev = new ArrayCollection();
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

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
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

    /**
     * @return Collection<int, Apprenant>
     */
    public function getDatev(): Collection
    {
        return $this->datev;
    }

    public function addDatev(Apprenant $datev): self
    {
        if (!$this->datev->contains($datev)) {
            $this->datev[] = $datev;
        }

        return $this;
    }

    public function removeDatev(Apprenant $datev): self
    {
        $this->datev->removeElement($datev);

        return $this;
    }
}
