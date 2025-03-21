<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Repository;

use AcmeWidgetCo\Delivery\Entity\ShipmentRule;

interface ShipmentRuleRepositoryInterface
{
    /**
     * @return ShipmentRule[]
     */
    public function getRules(): array;
}
