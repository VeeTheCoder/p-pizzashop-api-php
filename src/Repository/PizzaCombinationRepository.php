<?php

namespace App\Repository;

use App\Entity\PizzaCombination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaCombination|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaCombination|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaCombination[]    findAll()
 * @method PizzaCombination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaCombinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaCombination::class);
    }

    public function transform(PizzaCombination $pizzaCombination)
    {
        return [
                'id'    => (int) $pizzaCombination->getId(),
                'pizza_id'    => (int) $pizzaCombination->getPizzaId(),
                'ingredient_id' => (int) $pizzaCombination->getIngredientId(),
                'section_number' => (int) $pizzaCombination->getSectionNumber(),
                'price_dollar' => (int) $pizzaCombination->getPriceDollar(),
                'price_cent' => (int) $pizzaCombination->getPriceCent(),
                'price' => (string) $pizzaCombination->getPrice()
                ];
    }

    public function transformAll()
    {
        $pizzaCombinations = $this->findAll();
        $pizzaCombinationsArray = [];

        foreach ($pizzaCombinations as $pizzaCombination) {
            $pizzaCombinationsArray[] = $this->transform($pizzaCombination);
        }

        return $pizzaCombinationsArray;
    }
    
    public function getLastIdValue(){
        return $this->createQueryBuilder('i')
        ->select('MAX(i.pizza_id)')
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function getPizzaCombination($pizza_id,$partition_section,$ingredient_id){
        return $this->createQueryBuilder('i')
        ->andWhere('i.pizza_id = :pizza_id')
        ->setParameter('pizza_id', $pizza_id)
        ->andWhere('i.section_number = :section')
        ->setParameter('section', $partition_section)
        ->andWhere('i.ingredient_id = :ingredientid')
        ->setParameter('ingredientid', $ingredient_id)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function getPizzaCombinationByPizzaId($pizza_id){
        return $this->createQueryBuilder('i')
        ->andWhere('i.pizza_id = :pizza_id')
        ->setParameter('pizza_id', $pizza_id)
        ->getQuery()
        ->getResult();
    }
}
