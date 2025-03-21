<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;

interface OfferServiceInterface
{
    /**
     * Calculates and returns an array of discount entities for the given basket.
     *
     * @return DiscountInterface[]
     */
    public function calculateDiscounts(BasketInterface $basket): array;
}
