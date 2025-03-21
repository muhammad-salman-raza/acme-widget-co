<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Repository;

use AcmeWidgetCo\Delivery\Entity\ShipmentRule;

final readonly class ShipmentRuleRepository implements ShipmentRuleRepositoryInterface
{
    /**
     * @return ShipmentRule[]
     */
    public function getRules(): array
    {
        return [
            new ShipmentRule(0, 5000, 495, 'USD'),
            new ShipmentRule(5000, 9000, 295, 'USD'),
            new ShipmentRule(9000, null, 0, 'USD'),
        ];
    }
}
