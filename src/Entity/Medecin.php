<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedecinRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("telephone")
 */
class Medecin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matricule;
    /**
     * @ORM\Column(type="string", length=255)
     *   pattern="/^[a-zA-Z-]+$/i",
     *   message= "Votre nom ne doit pas contenir de chiffres")
     *  @Assert\Length(
     *      min = "2",  minMessage = "Votre nom doit avoir au moins deux lettres",
     *      max = "10", maxMessage = "votre nom doit avoir au plus dix lettres ")
     */
  
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     *   pattern="/^[a-zA-Z-]+$/i",
     *   message= "Votre nom ne doit pas contenir de chiffres")
     *  @Assert\Length(
     *      min = 2,  minMessage = "Votre nom doit avoir au moins deux lettres",
     *      max = 10, maxMessage = "votre nom doit avoir au plus dix lettres ")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Email(
     *   message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="medecins")
     * @ORM\JoinColumn(nullable=false)
     * 
     * )
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Specialites", inversedBy="medecins")
     */
    private $specialite;

    /**
     * @Assert\Regex(
     * pattern="#^7[0,6,7,8]([0-9]){7}$#",
     * message="numero de telephone invalide")
     * @ORM\Column(type="string")
     */
    private $telephone;

    public function __construct()
    {
        $this->specialite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|Specialites[]
     */
    public function getSpecialite(): Collection
    {
        return $this->specialite;
    }

    public function addSpecialite(Specialites $specialite): self
    {
        if (!$this->specialite->contains($specialite)) {
            $this->specialite[] = $specialite;
        }

        return $this;
    }

    public function removeSpecialite(Specialites $specialite): self
    {
        if ($this->specialite->contains($specialite)) {
            $this->specialite->removeElement($specialite);
        }

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}