<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]

class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Assert\Positive]
    private ?int $id = null;

    #[ORM\Column(type:'string',length: 50,unique:true)]
    #[Assert\NotBlank(message: 'Ce champ est obligatoire.')]
    #[Assert\Length(
        min: 3,
        minMessage: 'Ce champ doit contenir au moins 3 caractères.',
        max: 20,
        maxMessage: 'Ce champ ne peut pas contenir plus de 20 caractères.'
    )]
    #[Assert\Regex(
        pattern: '/^[a-z-]+$/i',
        message: 'Seules les lettres et les tirets sont autorisés.'
    )]
    private ?string $titreRecettes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Preparations = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoRecettes = null;

    #[ORM\Column(type:'integer',nullable: true)]
    #[Assert\Positive]
    private ?int $nbrAime = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotNull(message: 'Le statut ne peut pas être nul.')]
    private ?bool $statutRecettes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\DateTime(message: 'La date doit être valide au format DateTime.')]
    private ?\DateTimeInterface $DateRecettes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Categorie $categories = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Difficulte $difficultes = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?TypeRepas $repas = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?User $users = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'recettes')]
    private Collection $commentaires;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreRecettes(): ?string
    {
        return $this->titreRecettes;
    }

    public function setTitreRecettes(string $titreRecettes): static
    {
        $this->titreRecettes = strtolower($titreRecettes);

        return $this;
    }

    public function getPreparations(): ?string
    {
        return $this->Preparations;
    }

    public function setPreparations(?string $Preparations): static
    {
        $this->Preparations = $Preparations;

        return $this;
    }

    public function getPhotoRecettes(): ?string
    {
        return $this->photoRecettes;
    }

    public function setPhotoRecettes(?string $photoRecettes): static
    {
        $this->photoRecettes = $photoRecettes;

        return $this;
    }

    public function getNbrAime(): ?int
    {
        return $this->nbrAime;
    }

    public function setNbrAime(?int $nbrAime): static
    {
        $this->nbrAime = $nbrAime;

        return $this;
    }

    public function isStatutRecettes(): ?bool
    {
        return $this->statutRecettes;
    }

    public function setStatutRecettes(?bool $statutRecettes): static
    {
        $this->statutRecettes = $statutRecettes;

        return $this;
    }

    public function getDateRecettes(): ?\DateTimeInterface
    {
        return $this->DateRecettes;
    }

    public function setDateRecettes(?\DateTimeInterface $DateRecettes): static
    {
        $this->DateRecettes = $DateRecettes;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getDifficultes(): ?Difficulte
    {
        return $this->difficultes;
    }

    public function setDifficultes(?Difficulte $difficultes): static
    {
        $this->difficultes = $difficultes;

        return $this;
    }

    public function getRepas(): ?TypeRepas
    {
        return $this->repas;
    }

    public function setRepas(?TypeRepas $repas): static
    {
        $this->repas = $repas;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setRecettes($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getRecettes() === $this) {
                $commentaire->setRecettes(null);
            }
        }

        return $this;
    }
}
