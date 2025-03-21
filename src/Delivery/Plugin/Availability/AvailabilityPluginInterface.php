<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Plugin\Availability;

use AcmeWidgetCo\Shared\Entity\BasketInterface;

interface AvailabilityPluginInterface
{
    public function isAvailable(BasketInterface $basket): bool;
}
