<?php

namespace App\Repository;

use App\Entity\IngredientType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IngredientType|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientType|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientType[]    findAll()
 * @method IngredientType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientType::class);
    }

    public function transform(IngredientType $ingredientType)
    {
        return [
                'id'    => (int) $ingredientType->getId(),
                'ingredient_type' => (string) $ingredientType->getIngredientType()
                ];
    }

    public function transformAll()
    {
        $ingredientTypes = $this->findAll();
        $ingredientTypesArray = [];

        foreach ($ingredientTypes as $ingredientType) {
            $ingredientTypesArray[] = $this->transform($ingredientType);
        }

        return $ingredientTypesArray;
    }
}
