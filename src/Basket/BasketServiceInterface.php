<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use Money\Money;

interface BasketServiceInterface
{
    public function addProduct(BasketInterface $basket, ProductInterface $product, int $quantity): void;

    /**
     * @param DiscountInterface[] $discounts
     */
    public function setDiscounts(BasketInterface $basket, array $discounts): void;

    public function setShipment(BasketInterface $basket, ShipmentInterface $shipment): void;

    public function calculateSubTotal(BasketInterface $basket): ?Money;

    public function calculateGrandTotal(BasketInterface $basket): ?Money;
}
