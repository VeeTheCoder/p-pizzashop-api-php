<?php

namespace App\Repository;

use App\Entity\PizzaOrderLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaOrderLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaOrderLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaOrderLine[]    findAll()
 * @method PizzaOrderLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaOrderLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaOrderLine::class);
    }

    public function transform(PizzaOrderLine $pizzaOrderLine)
    {
        return [
                'id'    => (int) $pizzaOrderLine->getId(),
                'pizza_order_id' => (int) $pizzaOrderLine->getPizzaOrderId(),
                'pizza_combination_id' => (string) $pizzaOrderLine->getPizzaCombinationId(),
                'pizza_size_id' => (int) $pizzaOrderLine->getPizzaSizeId(),
                'price_dollar' => (int) $pizzaOrderLine->getPriceDollar(),
                'price_cent' => (int) $pizzaOrderLine->getPriceCent(),
                'price' => (string) $pizzaOrderLine->getPriceCent()
                ];
    }

    public function transformAll()
    {
        $pizzaOrderLines = $this->findAll();
        $pizzaOrderLinesArray = [];

        foreach ($pizzaOrderLines as $pizzaOrderLine) {
            $pizzaOrderLinesArray[] = $this->transform($pizzaOrderLine);
        }

        return $pizzaOrderLinesArray;
    }

    public function getAllOrderLinesByOrderId($orderId){
        return $this->createQueryBuilder('i')
        ->andWhere('i.order_id = :orderId')
        ->setParameter('orderId',$orderId)
        ->getQuery()
        ->getResult();
    }
}
