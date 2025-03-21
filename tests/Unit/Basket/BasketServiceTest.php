<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Basket;

use AcmeWidgetCo\Basket\BasketService;
use AcmeWidgetCo\Basket\Entity\Basket;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\Assert;

class BasketServiceTest extends TestCase
{
    public function testAddProduct(): void
    {
        $service = new BasketService();
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(1000, new Currency('USD')));

        $service->addProduct($basket, $productMock, 3);

        $items = $basket->getItems();
        $this->assertCount(1, $items);
        $this->assertEquals(3, $items[0]->getQuantity());
    }

    public function testCalculateSubTotalAndGrandTotal(): void
    {
        $service = new BasketService();
        $basket = new Basket();

        $productMock1 = $this->createMock(ProductInterface::class);
        $productMock1->method('getCode')->willReturn('P1');
        $productMock1->method('getPrice')->willReturn(new Money(2000, new Currency('USD')));

        $productMock2 = $this->createMock(ProductInterface::class);
        $productMock2->method('getCode')->willReturn('P2');
        $productMock2->method('getPrice')->willReturn(new Money(500, new Currency('USD')));

        $service->addProduct($basket, $productMock1, 1);
        $service->addProduct($basket, $productMock2, 2);

        $subTotal = $service->calculateSubTotal($basket);
        Assert::notNull($subTotal);
        $this->assertEquals(3000, $subTotal->getAmount());

        $grandTotal = $service->calculateGrandTotal($basket);
        Assert::notNull($grandTotal);
        $this->assertEquals(3000, $grandTotal->getAmount());
    }

    public function testSetDiscountsAndShipmentAffectGrandTotal(): void
    {
        $service = new BasketService();
        $basket = new Basket();

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('P1');
        $productMock->method('getPrice')->willReturn(new Money(5000, new Currency('USD')));

        $service->addProduct($basket, $productMock, 1);

        $discountMock = $this->createMock(DiscountInterface::class);
        $discountMock->method('getDiscountAmount')->willReturn(new Money(1000, new Currency('USD')));

        $shipmentMock = $this->createMock(ShipmentInterface::class);
        $shipmentMock->method('getPrice')->willReturn(new Money(500, new Currency('USD')));

        $service->setDiscounts($basket, [$discountMock]);
        $service->setShipment($basket, $shipmentMock);

        $grandTotal = $service->calculateGrandTotal($basket);
        Assert::notNull($grandTotal);
        $this->assertEquals(4500, $grandTotal->getAmount());
    }
}
