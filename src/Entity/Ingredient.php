<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'pizza', targetEntity: PizzaIngredients::class)]
    private Collection $pizzaIngredients;

    #[ORM\OneToMany(mappedBy: 'ingredients', targetEntity: PizzaIngredients::class)]
    private Collection $pizzas;

    public function __construct()
    {
        $this->pizzaIngredients = new ArrayCollection();
        $this->pizzas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, PizzaIngredients>
     */
    public function getPizzaIngredients(): Collection
    {
        return $this->pizzaIngredients;
    }

    public function addPizzaIngredient(PizzaIngredients $pizzaIngredient): self
    {
        if (!$this->pizzaIngredients->contains($pizzaIngredient)) {
            $this->pizzaIngredients->add($pizzaIngredient);
            $pizzaIngredient->setPizza($this);
        }

        return $this;
    }

    public function removePizzaIngredient(PizzaIngredients $pizzaIngredient): self
    {
        if ($this->pizzaIngredients->removeElement($pizzaIngredient)) {
            // set the owning side to null (unless already changed)
            if ($pizzaIngredient->getPizza() === $this) {
                $pizzaIngredient->setPizza(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PizzaIngredients>
     */
    public function getPizzas(): Collection
    {
        return $this->pizzas;
    }

    public function addPizza(PizzaIngredients $pizza): self
    {
        if (!$this->pizzas->contains($pizza)) {
            $this->pizzas->add($pizza);
            $pizza->setIngredients($this);
        }

        return $this;
    }

    public function removePizza(PizzaIngredients $pizza): self
    {
        if ($this->pizzas->removeElement($pizza)) {
            // set the owning side to null (unless already changed)
            if ($pizza->getIngredients() === $this) {
                $pizza->setIngredients(null);
            }
        }

        return $this;
    }
}
