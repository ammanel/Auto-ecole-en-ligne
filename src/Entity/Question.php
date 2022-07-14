<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question extends Infos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $intitule;

    
    

    #[ORM\ManyToMany(targetEntity: Proposition::class, inversedBy: 'questions',orphanRemoval:true)]
   /**
    * @ORM\JoinTable(name="repondre")
     */ 
    private $reponse;

    #[ORM\ManyToOne(targetEntity: Cours::class, inversedBy: 'questions')]
    private $coursDedie;

    public function __construct()
    {
        $this->reponse = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

  
   
    /**
     * @return Collection<int, Proposition>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(Proposition $reponse): self
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse[] = $reponse;
        }

        return $this;
    }

    public function removeReponse(Proposition $reponse): self
    {
        $this->reponse->removeElement($reponse);

        return $this;
    }

    public function getCoursDedie(): ?Cours
    {
        return $this->coursDedie;
    }

    

    public function setCoursDedie(?Cours $coursDedie): self
    {
        $this->coursDedie = $coursDedie;

        return $this;
    }

}
