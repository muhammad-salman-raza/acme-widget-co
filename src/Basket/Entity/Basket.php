<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket\Entity;

use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\BasketItemInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use Money\Currency;
use Money\Money;

class Basket implements BasketInterface
{
    /**
     * @var BasketItemInterface[]
     */
    private array $items = [];

    /**
     * @var DiscountInterface[]
     */
    private array $discounts = [];
    private ?ShipmentInterface $shipment = null;

    /**
     * @return BasketItemInterface[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(BasketItemInterface $item): void
    {
        foreach ($this->items as $existingItem) {
            if ($existingItem->getProduct()->getCode() === $item->getProduct()->getCode()) {
                $existingItem->setQuantity($existingItem->getQuantity() + $item->getQuantity());
                return;
            }
        }
        $this->items[] = $item;
    }

    /**
     * @param DiscountInterface[] $discounts
     */
    public function setDiscounts(array $discounts): void
    {
        $this->discounts = $discounts;
    }

    /**
     * @return DiscountInterface[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    public function setShipment(?ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }

    public function getShipment(): ?ShipmentInterface
    {
        return $this->shipment;
    }


    public function getSubTotal(): ?Money
    {
        if (empty($this->items)) {
            return null;
        }

        $subTotal = null;
        foreach ($this->items as $item) {
            $lineTotal = $item->getProduct()->getPrice()->multiply((string)$item->getQuantity());
            $subTotal = $subTotal ? $subTotal->add($lineTotal) : $lineTotal;
        }

        return $subTotal;
    }

    public function getCurrency(): Currency
    {
        $subTotal = $this->getSubTotal();
        if ($subTotal === null) {
            return new Currency('USD');
        }

        return $subTotal->getCurrency();
    }
    public function getTotalDiscount(): Money
    {
        $totalDiscount = new Money(0, $this->getCurrency());
        foreach ($this->discounts as $discount) {
            $totalDiscount = $totalDiscount->add($discount->getDiscountAmount());
        }
        return $totalDiscount;
    }

    public function getShipmentFee(): Money
    {
        if ($this->shipment !== null) {
            return $this->shipment->getPrice($this);
        }

        return new Money(0, $this->getCurrency());
    }

    public function getGrandTotal(): ?Money
    {
        $subTotal = $this->getSubTotal();

        if ($subTotal === null) {
            return null;
        }

        $totalDiscount = $this->getTotalDiscount();

        $shipmentFee = $this->getShipmentFee();

        return $subTotal
            ->subtract($totalDiscount)
            ->add($shipmentFee);
    }
}
