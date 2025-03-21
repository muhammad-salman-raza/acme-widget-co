<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product;

use AcmeWidgetCo\Product\Module;
use AcmeWidgetCo\Product\ProductServiceInterface;
use AcmeWidgetCo\Product\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{
    public function testGetDefinitions(): void
    {
        $module = new Module();
        $definitions = $module->getDefinitions();

        $this->assertIsArray($definitions);
        $this->assertArrayHasKey(ProductRepositoryInterface::class, $definitions);
        $this->assertArrayHasKey(ProductServiceInterface::class, $definitions);
    }
}
