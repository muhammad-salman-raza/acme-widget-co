<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Delivery\Plugin\Availability;

use AcmeWidgetCo\Delivery\Plugin\Availability\AlwaysAvailablePlugin;
use AcmeWidgetCo\Shared\Entity\BasketInterface;
use PHPUnit\Framework\TestCase;

class AlwaysAvailablePluginTest extends TestCase
{
    public function testIsAlwaysAvailable(): void
    {
        $plugin = new AlwaysAvailablePlugin();

        $basketMock = $this->createMock(BasketInterface::class);

        $this->assertTrue($plugin->isAvailable($basketMock));
    }
}
