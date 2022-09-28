<?php

namespace App\Entity;

use App\Repository\UeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UeRepository::class)
 */
class Ue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="ues")
     */
    private $filiere;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="ues")
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="ues",cascade={"persist"})
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true,unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=NotesEtudiant::class, mappedBy="Ue")
     */
    private $notesEtudiants;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ues")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Semestre::class, inversedBy="ues")
     */
    private $semestre;

    /**
     * @ORM\Column(type="float")
     */
    private $credit;
    

    public function __construct()
    {
        $this->notesEtudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * @return Collection|NotesEtudiant[]
     */
    public function getNotesEtudiants(): Collection
    {
        return $this->notesEtudiants;
    }

    public function addNotesEtudiant(NotesEtudiant $notesEtudiant): self
    {
        if (!$this->notesEtudiants->contains($notesEtudiant)) {
            $this->notesEtudiants[] = $notesEtudiant;
            $notesEtudiant->setUe($this);
        }

        return $this;
    }

    public function removeNotesEtudiant(NotesEtudiant $notesEtudiant): self
    {
        if ($this->notesEtudiants->removeElement($notesEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($notesEtudiant->getUe() === $this) {
                $notesEtudiant->setUe(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSemestre(): ?Semestre
    {
        return $this->semestre;
    }

    public function setSemestre(?Semestre $semestre): self
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(float $credit): self
    {
        $this->credit = $credit;

        return $this;
    }
}
