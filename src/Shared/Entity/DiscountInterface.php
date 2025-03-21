<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Shared\Entity;

use Money\Money;

interface DiscountInterface
{
    public function getName(): string;
    public function getDiscountAmount(): Money;
}
