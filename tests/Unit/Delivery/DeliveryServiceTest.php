<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery;

use AcmeWidgetCo\Delivery\DeliveryService;
use AcmeWidgetCo\Shared\Delivery\ShipmentInterface;
use PHPUnit\Framework\TestCase;

class DeliveryServiceTest extends TestCase
{
    public function testGetShipments(): void
    {
        $shipmentMock1 = $this->createMock(ShipmentInterface::class);
        $shipmentMock1->method('getCode')->willReturn('SHIP_1');

        $shipmentMock2 = $this->createMock(ShipmentInterface::class);
        $shipmentMock2->method('getCode')->willReturn('SHIP_2');

        $deliveryService = new DeliveryService([$shipmentMock1, $shipmentMock2]);

        $shipments = $deliveryService->getShipments();
        $this->assertCount(2, $shipments);

        $found = $deliveryService->getShipmentByCode('SHIP_1');
        $this->assertSame($shipmentMock1, $found);

        $this->assertNull($deliveryService->getShipmentByCode('UNKNOWN'));
    }
}
