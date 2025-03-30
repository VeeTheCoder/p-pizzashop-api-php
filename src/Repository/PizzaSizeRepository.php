<?php

namespace App\Repository;

use App\Entity\PizzaSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaSize[]    findAll()
 * @method PizzaSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaSize::class);
    }

    public function transform(PizzaSize $pizzaSize)
    {
        return [
                'id'    => (int) $pizzaSize->getId(),
                'size' => (int) $pizzaSize->getSize(),
                'price_dollar' => (int) $pizzaSize->getPriceDollar(),
                'price_cent' => (int) $pizzaSize->getPriceCent(),
                'price' => (string) $pizzaSize->getPrice()
                ];
    }

    public function transformAll()
    {
        $pizzaSizes = $this->findAll();
        $pizzaSizesArray = [];

        foreach ($pizzaSizes as $pizzaSize) {
            $pizzaSizesArray[] = $this->transform($pizzaSize);
        }

        return $pizzaSizesArray;
    }

}
