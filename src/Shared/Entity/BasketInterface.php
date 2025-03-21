<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Shared\Entity;

use AcmeWidgetCo\Basket\Entity\BasketItem;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use Money\Money;

interface BasketInterface
{
    /**
     * @return BasketItemInterface[]
     */
    public function getItems(): array;

    public function addItem(BasketItemInterface $item): void;

    /**
     * @return DiscountInterface[]
     */
    public function getDiscounts(): array;

    /**
     * @param DiscountInterface[] $discounts
     */
    public function setDiscounts(array $discounts): void;

    public function setShipment(?ShipmentInterface $shipment): void;
    public function getSubTotal(): ?Money;
    public function getTotalDiscount(): Money;

    public function getShipmentFee(): Money;

    public function getGrandTotal(): ?Money;
}
