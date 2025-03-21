<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Plugin\PriceCalculation;

use AcmeWidgetCo\Delivery\Plugin\PriceCalculation\StandardPriceCalculationPlugin;
use AcmeWidgetCo\Delivery\Repository\ShipmentRuleRepositoryInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use AcmeWidgetCo\Tests\KernelAwareTestCase;
use Money\Currency;
use Money\Money;

class StandardPriceCalculationPluginTest extends KernelAwareTestCase
{
    public function testReturnsFeeBasedOnRules(): void
    {
        $plugin = $this->container->get(StandardPriceCalculationPlugin::class);

        $basketMock = $this->createMock(BasketInterface::class);
        $basketMock->method('getSubTotal')
            ->willReturn(new Money(7000, new Currency('USD')));
        $basketMock->method('getTotalDiscount')
            ->willReturn(new Money(500, new Currency('USD')));

        $fee = $plugin->getPrice($basketMock);
        $this->assertEquals(295, $fee->getAmount());
        $this->assertEquals('USD', $fee->getCurrency()->getCode());
    }

    public function testNoRulesAppliedMeansFree(): void
    {
        $repoMock = $this->createMock(ShipmentRuleRepositoryInterface::class);
        $repoMock->method('getRules')->willReturn([]);

        $plugin = new StandardPriceCalculationPlugin($repoMock);

        $basketMock = $this->createMock(BasketInterface::class);
        $basketMock->method('getSubTotal')
            ->willReturn(new Money(10000, new Currency('USD')));
        $basketMock->method('getTotalDiscount')
            ->willReturn(new Money(0, new Currency('USD')));

        $fee = $plugin->getPrice($basketMock);
        $this->assertEquals(0, $fee->getAmount());
    }

    public function testZeroTotalMeansFree(): void
    {
        $repoMock = $this->createMock(ShipmentRuleRepositoryInterface::class);
        $repoMock->method('getRules')->willReturn([]);

        $plugin = new StandardPriceCalculationPlugin($repoMock);

        $basketMock = $this->createMock(BasketInterface::class);
        $basketMock->method('getSubTotal')
            ->willReturn(null);

        $fee = $plugin->getPrice($basketMock);
        $this->assertEquals(0, $fee->getAmount());
    }
}
