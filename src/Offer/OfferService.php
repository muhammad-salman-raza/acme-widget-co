<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\Offer\Plugin\OfferInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Shared\Entity\DiscountInterface;

class OfferService implements OfferServiceInterface
{
    /**
     * @var OfferInterface[]
     */
    protected array $offers;

    /**
     * @param iterable<OfferInterface> $offers
     */
    public function __construct(iterable $offers)
    {
        $this->offers = is_array($offers) ? $offers : iterator_to_array($offers);
    }

    /**
     * Iterates over each offer plugin and collects applicable discounts.
     *
     * @return DiscountInterface[]
     */
    public function calculateDiscounts(BasketInterface $basket): array
    {
        $discounts = [];
        foreach ($this->offers as $offer) {
            $discount = $offer->getDiscount($basket);
            if ($discount !== null) {
                $discounts[] = $discount;
            }
        }
        return $discounts;
    }
}
