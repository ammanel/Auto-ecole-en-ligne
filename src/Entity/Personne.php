<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[InheritanceType("JOINED")]
class Personne extends Infos implements UserInterface,PasswordAuthenticatedUserInterface 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    /**
     * @Assert\Regex(pattern="/^[+]{1}[0-9]{3}[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{2}$/",message="Format telephone +22891281270")
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $Telephone;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    /**
     * @Assert\Regex(pattern="/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/",message="min 8 caractères, aumoins une lettre majusscule, un nombre et un caratère spétiale ")
     */
    #[ORM\Column(type: 'string')]
    private $password;
    
    #[ORM\Column(type: 'string')]
    private $Nom;


    #[ORM\Column(type: 'string')]
    private $Addresse;

    /**
     * @Assert\Regex(pattern="/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",message="Respectez le format d'une addresse mail normale")
     */
            
    #[ORM\Column(type: 'string')]
    private $Mail;

    #[ORM\Column(type: 'boolean')]
    private $Statut;





    

    public function getNom()
    {
        return $this->Nom;
    }

    public function setNom(string $nom) :self
    {
        $this->Nom = $nom;
        return $this;
    }

   

    public function getAddresse()
    {
        return $this->Addresse;
    }

    public function setAddresse(string $Addresse) :self
    {
        $this->Addresse = $Addresse;
        return $this;
    }

    
    public function getMail()
    {
        return $this->Mail;
    }

    public function setMail(string $Mail) :self
    {
        $this->Mail = $Mail;
        return $this;
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->Telephone;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getStatut(): ?bool
    {
        return $this->Statut;
    }

    public function setStatut(bool $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }


}
