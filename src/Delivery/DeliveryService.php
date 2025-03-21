<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery;

use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;

final readonly class DeliveryService implements DeliveryServiceInterface
{
    /**
     * @param ShipmentInterface[] $shipments
     */
    public function __construct(
        private array $shipments
    ) {
    }

    public function getShipments(): array
    {
        return $this->shipments;
    }

    public function getShipmentByCode(string $code): ?ShipmentInterface
    {
        foreach ($this->shipments as $shipment) {
            if ($shipment->getCode() === $code) {
                return $shipment;
            }
        }

        return null;
    }
}
