<?php

namespace App\Entity;

use App\Repository\PizzaOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaOrderRepository::class)
 */
class PizzaOrder
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
    private $customer_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $order_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_status_id;

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

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getOrderDate(): ?string
    {
        return ($this->order_date)->format('Y-m-d H:i:s');
    }

    public function setOrderDate(): self
    {
        $this->order_date = new \DateTime("now");

        return $this;
    }

    public function getOrderStatusId(): ?int
    {
        return $this->order_status_id;
    }

    public function setOrderStatusId(int $order_status_id): self
    {
        $this->order_status_id = $order_status_id;

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
