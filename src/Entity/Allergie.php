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

    #[ORM\OneToOne(mappedBy: 'allergie', cascade: ['persist', 'remove'])]
    private ?User $userAllergie = null;

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

    public function getUserAllergie(): ?User
    {
        return $this->userAllergie;
    }

    public function setUserAllergie(?User $userAllergie): self
    {
        // unset the owning side of the relation if necessary
        if ($userAllergie === null && $this->userAllergie !== null) {
            $this->userAllergie->setAllergie(null);
        }

        // set the owning side of the relation if necessary
        if ($userAllergie !== null && $userAllergie->getAllergie() !== $this) {
            $userAllergie->setAllergie($this);
        }

        $this->userAllergie = $userAllergie;

        return $this;
    }
}
