<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Shipment;

use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Delivery\Plugin\Availability\AvailabilityPluginInterface;
use AcmeWidgetCo\Delivery\Plugin\PriceCalculation\PriceCalculationPluginInterface;
use Money\Money;

final readonly class StandardShipment implements ShipmentInterface
{
    public function __construct(
        private AvailabilityPluginInterface $availabilityPlugin,
        private PriceCalculationPluginInterface $priceCalculationPlugin,
        private string $name = 'Standard Shipment',
        private string $code = 'STANDARD'
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function isAvailable(BasketInterface $basket): bool
    {
        return $this->availabilityPlugin->isAvailable($basket);
    }

    public function getPrice(BasketInterface $basket): Money
    {
        return $this->priceCalculationPlugin->getPrice($basket);
    }
}
