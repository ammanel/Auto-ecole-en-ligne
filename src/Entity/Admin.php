<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string')]
    private $Prenom;


 
    #[ORM\Column(type: 'string')]
    private $Sex;

    

    public function getPrenom()
    {
        return $this->Prenom;
    }

   

    public function getSex()
    {
        return $this->Sex;
    }

   

    public function setSex(string $Sex) :self
    {
        $this->Sex = $Sex;
        return $this;
    }

    public function setPrenom(string $prenom) :self
    {
        $this->Prenom = $prenom;
        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }
}
