<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\Basket\Entity\BasketItem;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use Money\Money;

readonly class BasketService implements BasketServiceInterface
{
    public function addProduct(BasketInterface $basket, ProductInterface $product, int $quantity): void
    {
        $basket->addItem(new BasketItem($product, $quantity));
    }

    /**
     * @param DiscountInterface[] $discounts
     */
    public function setDiscounts(BasketInterface $basket, array $discounts): void
    {
        $basket->setDiscounts($discounts);
    }

    public function setShipment(BasketInterface $basket, ShipmentInterface $shipment): void
    {
        $basket->setShipment($shipment);
    }

    public function calculateSubTotal(BasketInterface $basket): ?Money
    {
        return $basket->getSubTotal();
    }

    public function calculateGrandTotal(BasketInterface $basket): ?Money
    {
        return $basket->getGrandTotal();
    }
}
