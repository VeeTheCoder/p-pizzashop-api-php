<?php

namespace App\Repository;

use App\Entity\PizzaIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaIngredient|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaIngredient|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaIngredient[]    findAll()
 * @method PizzaIngredient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaIngredient::class);
    }

    public function transform(PizzaIngredient $pizzaIngredient)
    {
        return [
                'id'    => (int) $pizzaIngredient->getId(),
                'ingredient_name' => (string) $pizzaIngredient->getIngredientName(),
                'ingredient_type_id' => (string) $pizzaIngredient->getIngredientTypeId(),
                'price_dollar' => (int) $pizzaIngredient->getPriceDollar(),
                'price_cent' => (int) $pizzaIngredient->getPriceCent(),
                'price' => (string) $pizzaIngredient->getPriceCent()
                ];
    }

    public function transformAll()
    {
        $pizzaIngredients = $this->findAll();
        $pizzaIngredientsArray = [];

        foreach ($pizzaIngredients as $pizzaIngredient) {
            $pizzaIngredientsArray[] = $this->transform($pizzaIngredient);
        }

        return $pizzaIngredientsArray;
    }
}
