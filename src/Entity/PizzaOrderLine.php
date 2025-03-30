<?php

namespace App\Entity;

use App\Repository\PizzaOrderLineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaOrderLineRepository::class)
 */
class PizzaOrderLine
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
    private $pizza_order_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pizza_combination_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $pizza_size_id;

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

    public function getPizzaOrderId(): ?int
    {
        return $this->pizza_order_id;
    }

    public function setPizzaOrderId(int $pizza_order_id): self
    {
        $this->pizza_order_id = $pizza_order_id;

        return $this;
    }

    public function getPizzaCombinationId(): ?int
    {
        return $this->pizza_combination_id;
    }

    public function setPizzaCombinationId(int $pizza_combination_id): self
    {
        $this->pizza_combination_id = $pizza_combination_id;

        return $this;
    }

    public function getPizzaSizeId(): ?int
    {
        return $this->pizza_size_id;
    }

    public function setPizzaSizeId(int $pizza_size_id): self
    {
        $this->pizza_size_id = $pizza_size_id;

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
