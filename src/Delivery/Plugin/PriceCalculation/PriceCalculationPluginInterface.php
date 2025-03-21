<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Plugin\PriceCalculation;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use Money\Money;

interface PriceCalculationPluginInterface
{
    public function getPrice(BasketInterface $basket): Money;
}
