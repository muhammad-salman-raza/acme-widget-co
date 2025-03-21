<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product;

use AcmeWidgetCo\Product\ProductService;
use AcmeWidgetCo\Product\ProductServiceInterface;
use AcmeWidgetCo\Product\Repository\ProductRepository;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    private ProductServiceInterface $service;

    protected function setUp(): void
    {
        $repository = new ProductRepository();
        $this->service = new ProductService($repository);
    }

    public function testFetchAllProducts(): void
    {
        $products = $this->service->fetchAllProducts();
        $this->assertIsArray($products);
        $this->assertCount(3, $products);

        foreach ($products as $product) {
            $this->assertInstanceOf(ProductInterface::class, $product);
        }
    }

    public function testFetchProductByCode(): void
    {
        $product = $this->service->fetchProductByCode('G01');
        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('G01', $product->getCode());
    }

    public function testFetchProductByCodeReturnsNullWhenCodeNotFound(): void
    {
        $this->assertNull($this->service->fetchProductByCode('NON_EXISTENT'));
    }
}
