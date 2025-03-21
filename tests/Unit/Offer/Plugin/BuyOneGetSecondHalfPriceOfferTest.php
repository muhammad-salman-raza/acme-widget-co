<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Offer\Plugin;

use AcmeWidgetCo\Offer\Plugin\BuyOneGetSecondHalfPriceOffer;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\BasketItemInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class BuyOneGetSecondHalfPriceOfferTest extends TestCase
{
    public function testGetDiscountReturnsNullWhenNotEnoughItems(): void
    {
        $basketMock = $this->createMock(BasketInterface::class);

        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('R01');
        $productMock->method('getPrice')->willReturn(new Money(3295, new Currency('USD')));

        $basketItemMock = $this->createMock(BasketItemInterface::class);
        $basketItemMock->method('getProduct')->willReturn($productMock);
        $basketItemMock->method('getQuantity')->willReturn(1);

        $basketMock->method('getItems')->willReturn([$basketItemMock]);

        $offer = new BuyOneGetSecondHalfPriceOffer();
        $discount = $offer->getDiscount($basketMock);

        $this->assertNull(
            $discount,
            'Discount should be null when less than 2 applicable items are in the basket.'
        );
    }

    public function testGetDiscountReturnsDiscountWhenEnoughItems(): void
    {
        $basketMock = $this->createMock(BasketInterface::class);
        $productMock = $this->createMock(ProductInterface::class);
        $productMock->method('getCode')->willReturn('R01');
        $productMock->method('getPrice')->willReturn(new Money(3295, new Currency('USD')));

        $basketItemMock = $this->createMock(BasketItemInterface::class);
        $basketItemMock->method('getProduct')->willReturn($productMock);
        $basketItemMock->method('getQuantity')->willReturn(3);

        $basketMock->method('getItems')->willReturn([$basketItemMock]);

        $offerName = 'Special Red Offer';
        $offer = new BuyOneGetSecondHalfPriceOffer($offerName, 'R01');
        $discount = $offer->getDiscount($basketMock);

        $this->assertInstanceOf(DiscountInterface::class, $discount);
        $this->assertEquals($offerName, $discount->getName());

        $this->assertEquals(1648, $discount->getDiscountAmount()->getAmount());
        $this->assertEquals('USD', $discount->getDiscountAmount()->getCurrency()->getCode());
    }
}
