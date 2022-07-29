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

    #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'datev')]
    private $posts;

    #[ORM\OneToMany(mappedBy: 'compte', targetEntity: Document::class)]
    private $documents;

  


    public function __construct()
    {
        $this->leçonApprise = new ArrayCollection();
        $this->coursAppris = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->documents = new ArrayCollection();
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

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addDatev($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeDatev($this);
        }

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
            $document->setCompte($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getCompte() === $this) {
                $document->setCompte(null);
            }
        }

        return $this;
    }

   

   


}
