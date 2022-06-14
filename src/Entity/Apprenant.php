<?php

namespace App\Entity;

use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[ORM\Entity(repositoryClass: ApprenantRepository::class)]
#[UniqueEntity(fields: ['Telephone'], message: 'There is already an account with this Telephone')]
class Apprenant extends Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;



    #[ORM\Column(type: 'string')]
    private $Prenom;


 
    #[ORM\Column(type: 'string')]
    private $Sex;

    #[ORM\ManyToMany(targetEntity: Cours::class, inversedBy: 'apprenants')]
    private $coursAppris;

  


    public function __construct()
    {
        $this->leçonApprise = new ArrayCollection();
        $this->coursAppris = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
    }

    

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

    /**
     * @return Collection<int, Cours>
     */
    public function getCoursAppris(): Collection
    {
        return $this->coursAppris;
    }

    public function addCoursAppri(Cours $coursAppri): self
    {
        if (!$this->coursAppris->contains($coursAppri)) {
            $this->coursAppris[] = $coursAppri;
        }

        return $this;
    }

    public function removeCoursAppri(Cours $coursAppri): self
    {
        $this->coursAppris->removeElement($coursAppri);

        return $this;
    }

   

   


}
