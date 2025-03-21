<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Plugin;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;

interface OfferInterface
{
    /**
     * Returns a discount entity for the given basket if the offer applies,
     * or null otherwise.
     */
    public function getDiscount(BasketInterface $basket): ?DiscountInterface;
}
