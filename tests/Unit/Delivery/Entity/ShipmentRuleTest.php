<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Entity;

use AcmeWidgetCo\Delivery\Entity\ShipmentRule;
use Money\Money;
use PHPUnit\Framework\TestCase;

class ShipmentRuleTest extends TestCase
{
    public function testAppliesToRange(): void
    {
        $rule = new ShipmentRule(100, 5000, 495, 'USD');

        $this->assertTrue($rule->appliesTo(100));
        $this->assertTrue($rule->appliesTo(4999));
        $this->assertFalse($rule->appliesTo(99));
        $this->assertFalse($rule->appliesTo(5000));
    }

    public function testGetFee(): void
    {
        $rule = new ShipmentRule(0, 5000, 495, 'USD');
        $fee = $rule->getFee();
        $this->assertInstanceOf(Money::class, $fee);
        $this->assertEquals(495, $fee->getAmount());
        $this->assertEquals('USD', $fee->getCurrency()->getCode());
    }
}
