<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product\Repository;

use AcmeWidgetCo\Product\Repository\ProductRepository;
use AcmeWidgetCo\Product\Repository\ProductRepositoryInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;
use PHPUnit\Framework\TestCase;

class ProductRepositoryTest extends TestCase
{
    private ProductRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = new ProductRepository();
    }

    public function testGetAllProducts(): void
    {
        $products = $this->repository->getAllProducts();
        $this->assertIsArray($products);
        $this->assertCount(3, $products);

        foreach ($products as $product) {
            $this->assertInstanceOf(ProductInterface::class, $product);
        }
    }

    public function testGetProductByCode(): void
    {
        $product = $this->repository->getProductByCode('G01');
        $this->assertInstanceOf(ProductInterface::class, $product);
        $this->assertEquals('G01', $product->getCode());
    }

    public function testGetProductByCodeReturnsNullWhenCodeNotFound(): void
    {
        $this->assertNull($this->repository->getProductByCode('NON_EXISTENT'));
    }
}
