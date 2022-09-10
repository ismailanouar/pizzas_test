<?php

namespace App\Entity;

use App\Repository\AllergieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AllergieRepository::class)]
class Allergie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $ingredients;

    #[ORM\OneToOne(mappedBy: 'allergies', cascade: ['persist', 'remove'])]
    private ?User $userAllergies = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    public function getUserAllergies(): ?User
    {
        return $this->userAllergies;
    }

    public function setUserAllergies(?User $userAllergies): self
    {
        // unset the owning side of the relation if necessary
        if ($userAllergies === null && $this->userAllergies !== null) {
            $this->userAllergies->setAllergies(null);
        }

        // set the owning side of the relation if necessary
        if ($userAllergies !== null && $userAllergies->getAllergies() !== $this) {
            $userAllergies->setAllergies($this);
        }

        $this->userAllergies = $userAllergies;

        return $this;
    }
}
