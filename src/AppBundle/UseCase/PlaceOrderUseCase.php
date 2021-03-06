<?php

namespace AppBundle\UseCase;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Dollar;
use AppBundle\Entity\ProductOrder;
use Doctrine\ORM\EntityManager;

class PlaceOrderUseCase
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Customer $customer
     * @param string   $productReference
     * @param int      $quantity
     *
     * @throws \DomainException
     */
    public function execute(Customer $customer, string $productReference, int $quantity)
    {
        $this->em->transactional(function () use ($customer, $productReference, $quantity) {
            $price = new Dollar(2999 * $quantity);
            $fees = new Dollar(1000 + 500 * $quantity);
            $deliveryDate = new \DateTime('tomorrow');

            $this->em->persist(
                new ProductOrder($customer, $productReference, $quantity, $price, $fees, $deliveryDate)
            );
        });
    }
}
