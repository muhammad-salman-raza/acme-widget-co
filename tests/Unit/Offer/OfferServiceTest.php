<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Offer;

use AcmeWidgetCo\Offer\Entity\Discount;
use AcmeWidgetCo\Offer\OfferService;
use AcmeWidgetCo\Offer\OfferServiceInterface;
use AcmeWidgetCo\Offer\Plugin\OfferInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class OfferServiceTest extends TestCase
{
    public function testCalculateDiscountsAggregatesApplicableDiscounts(): void
    {
        $basketMock = $this->createMock(BasketInterface::class);

        $discount1 = new Discount('Offer 1', new Money(500, new Currency('USD')));
        $discount2 = new Discount('Offer 2', new Money(300, new Currency('USD')));


        $offerMock1 = $this->createMock(OfferInterface::class);
        $offerMock1->method('getDiscount')
            ->with($basketMock)
            ->willReturn($discount1);

        $offerMock2 = $this->createMock(OfferInterface::class);
        $offerMock2->method('getDiscount')
            ->with($basketMock)
            ->willReturn($discount2);

        $offerMock3 = $this->createMock(OfferInterface::class);
        $offerMock3->method('getDiscount')
            ->with($basketMock)
            ->willReturn(null);

        $offers = [$offerMock1, $offerMock2, $offerMock3];

        /** @var OfferServiceInterface $offerService */
        $offerService = new OfferService($offers);

        $discounts = $offerService->calculateDiscounts($basketMock);
        $this->assertCount(2, $discounts, 'Only two offers should yield discounts.');

        $totalDiscount = 0;
        foreach ($discounts as $discount) {
            $this->assertInstanceOf(DiscountInterface::class, $discount);
            $totalDiscount += (int)$discount->getDiscountAmount()->getAmount();
        }
        $this->assertEquals(800, $totalDiscount, 'Total discount should equal 500 + 300 = 800 cents.');
    }
}
