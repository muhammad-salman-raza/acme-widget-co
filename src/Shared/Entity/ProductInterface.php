<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Shared\Entity;

use Money\Money;

interface ProductInterface
{
    public function getName(): string;
    public function getCode(): string;
    public function getPrice(): Money;
}
