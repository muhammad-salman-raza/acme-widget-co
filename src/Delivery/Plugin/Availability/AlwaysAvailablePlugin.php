<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Plugin\Availability;

use AcmeWidgetCo\Shared\Entity\BasketInterface;

final readonly class AlwaysAvailablePlugin implements AvailabilityPluginInterface
{
    public function isAvailable(BasketInterface $basket): bool
    {
        return true;
    }
}
