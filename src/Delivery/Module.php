<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery;

use AcmeWidgetCo\Delivery\Repository\ShipmentRuleRepository;
use AcmeWidgetCo\Delivery\Repository\ShipmentRuleRepositoryInterface;
use AcmeWidgetCo\Delivery\Shipment\StandardShipment;
use AcmeWidgetCo\ModuleInterface;
use AcmeWidgetCo\Delivery\Plugin\Availability\AvailabilityPluginInterface;
use AcmeWidgetCo\Delivery\Plugin\Availability\AlwaysAvailablePlugin;
use AcmeWidgetCo\Delivery\Plugin\PriceCalculation\PriceCalculationPluginInterface;
use AcmeWidgetCo\Delivery\Plugin\PriceCalculation\StandardPriceCalculationPlugin;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use DI;

class Module implements ModuleInterface
{
    public function getDefinitions(): array
    {
        return [
            ShipmentRuleRepositoryInterface::class => \DI\create(ShipmentRuleRepository::class),
            AvailabilityPluginInterface::class => DI\create(AlwaysAvailablePlugin::class),
            PriceCalculationPluginInterface::class => DI\autowire(StandardPriceCalculationPlugin::class),

            ShipmentInterface::class => DI\autowire(StandardShipment::class)
                ->constructorParameter('availabilityPlugin', \DI\get(AvailabilityPluginInterface::class))
                ->constructorParameter('priceCalculationPlugin', \DI\get(PriceCalculationPluginInterface::class)),

            DeliveryServiceInterface::class => DI\autowire(DeliveryService::class)
                ->constructorParameter('shipments', [\DI\get(ShipmentInterface::class)]),
        ];
    }
}
