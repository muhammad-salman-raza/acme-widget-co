<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer\Entity;

use AcmeWidgetCo\Shared\Entity\DiscountInterface;
use Money\Money;

class Discount implements DiscountInterface
{
    public function __construct(
        private string $name,
        private Money $discountAmount
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiscountAmount(): Money
    {
        return $this->discountAmount;
    }
}
