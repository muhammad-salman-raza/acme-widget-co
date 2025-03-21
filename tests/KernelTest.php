<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests;

use AcmeWidgetCo\Kernel;
use AcmeWidgetCo\Product\ProductServiceInterface;
use AcmeWidgetCo\Product\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class KernelTest extends TestCase
{
    public function testKernelBuildsContainer(): void
    {
        $kernel = new Kernel();
        $container = $kernel->getContainer();

        $this->assertInstanceOf(ContainerInterface::class, $container);
    }

    public function testKernelDiscoveredModules(): void
    {
        $kernel = new Kernel();
        $container = $kernel->getContainer();

        $this->assertTrue($container->has(ProductRepositoryInterface::class));
        $this->assertTrue($container->has(ProductServiceInterface::class));
    }

    public function testGetProductServiceFromContainer(): void
    {
        $kernel = new Kernel();
        $container = $kernel->getContainer();
        $service = $container->get(ProductServiceInterface::class);

        $this->assertInstanceOf(ProductServiceInterface::class, $service);
    }
}
