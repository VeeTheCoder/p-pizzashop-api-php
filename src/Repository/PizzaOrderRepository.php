<?php

namespace App\Repository;

use App\Entity\PizzaOrder;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaOrder[]    findAll()
 * @method PizzaOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaOrder::class);
    }

    public function transform(PizzaOrder $pizzaOrder)
    {
        return [
                'id'    => (int) $pizzaOrder->getId(),
                'customer_id' => (int) $pizzaOrder->getCustomerId(),
                'order_date' => (string) $pizzaOrder->getOrderDate(),
                'order_status_id' => (int) $pizzaOrder->getOrderStatusId(),
                'price_dollar' => (int) $pizzaOrder->getPriceDollar(),
                'price_cent' => (int) $pizzaOrder->getPriceCent(),
                'price' => (string) $pizzaOrder->getPrice()
                ];
    }

    public function transformAll()
    {
        $pizzaOrders = $this->findAll();
        $pizzaOrdersArray = [];

        foreach ($pizzaOrders as $pizzaOrder) {
            $pizzaOrdersArray[] = $this->transform($pizzaOrder);
        }

        return $pizzaOrdersArray;
    }
}
