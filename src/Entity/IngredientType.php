<?php

namespace App\Entity;

use App\Repository\IngredientTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngredientTypeRepository::class)
 */
class IngredientType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $ingredient_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredientType(): ?string
    {
        return $this->ingredient_type;
    }

    public function setIngredientType(string $ingredient_type): self
    {
        $this->ingredient_type = $ingredient_type;

        return $this;
    }
}
