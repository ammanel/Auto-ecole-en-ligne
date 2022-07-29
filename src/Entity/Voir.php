<?php

namespace App\Entity;

use App\Repository\VoirRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoirRepository::class)]
class Voir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $post_id;

    #[ORM\Column(type: 'integer')]
    private $apprenant_id;

    #[ORM\Column(type: 'date')]
    private $datevisualisation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function setPostId(int $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }

    public function getApprenantId(): ?int
    {
        return $this->apprenant_id;
    }

    public function setApprenantId(int $apprenant_id): self
    {
        $this->apprenant_id = $apprenant_id;

        return $this;
    }

    public function getDatevisualisation(): ?\DateTimeInterface
    {
        return $this->datevisualisation;
    }

    public function setDatevisualisation(\DateTimeInterface $datevisualisation): self
    {
        $this->datevisualisation = $datevisualisation;

        return $this;
    }
}
