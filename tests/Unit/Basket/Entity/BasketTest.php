<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Basket\Entity;

use AcmeWidgetCo\Basket\Entity\Basket;
use AcmeWidgetCo\Basket\Entity\BasketItem;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;

class BasketTest extends TestCase
{
    public function testTotalsWhenBasketIsEmpty(): void
    {
        $basket = new Basket();

        $this->assertNull($basket->getSubTotal());
        $this->assertNull($basket->getGrandTotal());
        $this->assertSame('USD', $basket->getCurrency()->getCode());
    }

    public function testAddItemAndCalculateSubTotal(): void
    {
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(1000, new Currency('USD')));

        $basketItem = new BasketItem($productMock, 2);
        $basket->addItem($basketItem);

        $subTotal = $basket->getSubTotal();
        $this->assertInstanceOf(Money::class, $subTotal);
        $this->assertEquals(2000, $subTotal->getAmount());
    }

    public function testAddSameProductIncrementsQuantity(): void
    {
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(1000, new Currency('USD')));

        $basket->addItem(new BasketItem($productMock, 1));
        $basket->addItem(new BasketItem($productMock, 3));

        $items = $basket->getItems();
        $this->assertCount(1, $items);
        $this->assertEquals(4, $items[0]->getQuantity());
    }

    public function testSetDiscountsAffectsGrandTotal(): void
    {
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(1500, new Currency('USD')));

        $basket->addItem(new BasketItem($productMock, 2));

        $discountMock = $this->createMock(DiscountInterface::class);
        $discountMock->method('getDiscountAmount')->willReturn(new Money(500, new Currency('USD')));
        $discountMock->method('getName')->willReturn('Test Discount');

        $basket->setDiscounts([$discountMock]);

        $grandTotal = $basket->getGrandTotal();
        Assert::notNull($grandTotal);

        $this->assertEquals(2500, $grandTotal->getAmount());

        $discounts = $basket->getDiscounts();
        $this->assertCount(1, $discounts);
    }

    public function testSetShipmentAffectsGrandTotal(): void
    {
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(1000, new Currency('USD')));

        $basket->addItem(new BasketItem($productMock, 2));
        $shipmentMock = $this->createMock(ShipmentInterface::class);
        $shipmentMock->method('getPrice')->willReturn(new Money(495, new Currency('USD')));
        $shipmentMock->method('getName')->willReturn('Test Shipment');
        $shipmentMock->method('getCode')->willReturn('TEST_SHIP');

        $basket->setShipment($shipmentMock);

        $grandTotal = $basket->getGrandTotal();
        Assert::notNull($grandTotal);
        $this->assertEquals(2495, $grandTotal->getAmount());

        $shipment = $basket->getShipment();
        $this->assertInstanceOf(ShipmentInterface::class, $shipment);
        $this->assertSame('495', $shipment->getPrice($basket)->getAmount());
    }

    public function testGrandTotalCombinesDiscountsAndShipment(): void
    {
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(10000, new Currency('USD')));

        $basket->addItem(new BasketItem($productMock, 1));

        $discountMock = $this->createMock(DiscountInterface::class);
        $discountMock->method('getDiscountAmount')->willReturn(new Money(1000, new Currency('USD')));

        $shipmentMock = $this->createMock(ShipmentInterface::class);
        $shipmentMock->method('getPrice')->willReturn(new Money(500, new Currency('USD')));

        $basket->setDiscounts([$discountMock]);
        $basket->setShipment($shipmentMock);

        $grandTotal = $basket->getGrandTotal();
        Assert::notNull($grandTotal);

        $this->assertEquals(9500, $grandTotal->getAmount());
    }
}
