<?php

namespace App\Entity;

use App\Repository\PizzaCombinationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaCombinationRepository::class)
 */
class PizzaCombination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pizza_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $ingredient_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $section_number;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_dollar;

    /**
     * @ORM\Column(type="smallint")
     */
    private $price_cent;

    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPizzaId(): ?int
    {
        return $this->pizza_id;
    }

    public function setPizzaId(int $pizza_id): self
    {
        $this->pizza_id = $pizza_id;

        return $this;
    }

    public function getIngredientId(): ?int
    {
        return $this->ingredient_id;
    }

    public function setIngredientId(int $ingredient_id): self
    {
        $this->ingredient_id = $ingredient_id;

        return $this;
    }

    public function getSectionNumber(): ?int
    {
        return $this->section_number;
    }

    public function setSectionNumber(int $section_number): self
    {
        $this->section_number = $section_number;

        return $this;
    }

    public function getPriceDollar(): ?int
    {
        $this->setPrice();
        return $this->price_dollar;
    }

    public function setPriceDollar(int $price_dollar): self
    {
        $this->price_dollar = $price_dollar;
        $this->setPrice();
        
        return $this;
    }

    public function getPriceCent(): ?int
    {
        $this->setPrice();
        return $this->price_cent;
    }

    public function setPriceCent(int $price_cent): self
    {
        $this->price_cent = $price_cent;
        $this->setPrice();

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    private function setPrice(): self
    {
        $this->price = strval($this->price_dollar) . "." . strval($this->price_cent);

        return $this;
    }
}
