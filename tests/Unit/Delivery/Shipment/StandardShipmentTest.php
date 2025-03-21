<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Shipment;

use AcmeWidgetCo\Delivery\Plugin\Availability\AvailabilityPluginInterface;
use AcmeWidgetCo\Delivery\Plugin\PriceCalculation\PriceCalculationPluginInterface;
use AcmeWidgetCo\Delivery\Shipment\StandardShipment;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class StandardShipmentTest extends TestCase
{
    public function testShipmentDelegatesToPlugins(): void
    {
        $availabilityMock = $this->createMock(AvailabilityPluginInterface::class);
        $availabilityMock->method('isAvailable')->willReturn(true);

        $priceMock = $this->createMock(PriceCalculationPluginInterface::class);
        $priceMock->method('getPrice')->willReturn(new Money(295, new Currency('USD')));

        $shipment = new StandardShipment($availabilityMock, $priceMock, 'Test Shipment', 'TEST_CODE');

        $this->assertEquals('Test Shipment', $shipment->getName());
        $this->assertEquals('TEST_CODE', $shipment->getCode());

        $basketMock = $this->createMock(BasketInterface::class);
        $this->assertTrue($shipment->isAvailable($basketMock));

        $fee = $shipment->getPrice($basketMock);
        $this->assertEquals(295, $fee->getAmount());
        $this->assertEquals('USD', $fee->getCurrency()->getCode());
    }
}
