<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
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
    private ?string $categories = null;
    

    #[ORM\Column(type: 'boolean', nullable: false)]
    #[Assert\NotNull(message: 'Le statut ne peut pas être nul.')]

    private ?bool $statutCategories = null;

    /**
     * @var Collection<int, Recette>
     */
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'categories')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(string $categories): static
    {
        $this->categories = strtolower($categories);

        return $this;
    }

    public function isStatutCategories(): ?bool
    {
        return $this->statutCategories;
    }

    public function setStatutCategories(bool $statutCategories): static
    {
        $this->statutCategories = $statutCategories;

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
            $recette->setCategories($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getCategories() === $this) {
                $recette->setCategories(null);
            }
        }

        return $this;
    }   
}
