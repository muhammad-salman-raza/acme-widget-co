<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Plugin;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use AcmeWidgetCo\Offer\Entity\Discount;
use Money\Money;
use Money\Currency;
use Money\RoundingMode;

final readonly class BuyOneGetSecondHalfPriceOffer implements OfferInterface
{
    public function __construct(
        protected string $offerName = 'Buy one, get second half price',
        protected string $applicableProductCode = 'R01'
    ) {
    }

    public function getDiscount(BasketInterface $basket): ?DiscountInterface
    {
        $totalCount = 0;
        $unitPrice = null;

        foreach ($basket->getItems() as $item) {
            if ($item->getProduct()->getCode() === $this->applicableProductCode) {
                $totalCount += $item->getQuantity();
                $unitPrice = $item->getProduct()->getPrice();
            }
        }

        if ($unitPrice === null || $totalCount < 2) {
            return null;
        }

        $pairs = intdiv($totalCount, 2);
        $amount = (int) $unitPrice->getAmount();
        $halfPrice = (int) round($amount * 0.5, 0, PHP_ROUND_HALF_UP);
        $discountAmount = $halfPrice * $pairs;
        $discountMoney = new Money($discountAmount, new Currency($unitPrice->getCurrency()->getCode()));

        return new Discount($this->offerName, $discountMoney);
    }
}
