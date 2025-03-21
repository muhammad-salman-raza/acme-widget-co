<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Shared\Delivery;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use Money\Money;

interface ShipmentInterface
{
    public function getName(): string;
    public function getCode(): string;
    public function isAvailable(BasketInterface $basket): bool;
    public function getPrice(BasketInterface $basket): Money;
}
