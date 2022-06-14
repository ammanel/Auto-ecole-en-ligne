<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $enable=0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
