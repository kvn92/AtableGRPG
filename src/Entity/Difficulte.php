<?php

namespace App\Entity;

use App\Repository\DifficulteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DifficulteRepository::class)]



class Difficulte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Assert\Positive]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
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
    private ?string $difficultes = null;

    #[ORM\Column]
    private ?bool $statutDifficultes = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'difficultes')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(string $difficultes): static
    {
        $this->difficultes = strtolower($difficultes);

        return $this;
    }

    public function isStatutDifficultes(): ?bool
    {
        return $this->statutDifficultes;
    }

    public function setStatutDifficultes(bool $statutDifficultes): static
    {
        $this->statutDifficultes = $statutDifficultes;

        return $this;
    }

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->setDifficultes($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getDifficultes() === $this) {
                $recette->setDifficultes(null);
            }
        }

        return $this;
    }
}
