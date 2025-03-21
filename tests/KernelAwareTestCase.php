<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests;

use PHPUnit\Framework\TestCase;
use AcmeWidgetCo\Kernel;
use Psr\Container\ContainerInterface;

class KernelAwareTestCase extends TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = new Kernel();
        $this->container = $kernel->getContainer();
    }
}
