<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery;

use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;

interface DeliveryServiceInterface
{
    /**
     * @return ShipmentInterface[]
     */
    public function getShipments(): array;

    public function getShipmentByCode(string $code): ?ShipmentInterface;
}
