<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Unit\Product\Entity;

use AcmeWidgetCo\Product\Entity\ConcreteProduct;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class ConcreteProductTest extends TestCase
{
    public function testProductConstructorAndGetPrice(): void
    {
        $product = new ConcreteProduct('Test Product', 'TP01', 1000, 'usd');
        $price = $product->getPrice();

        $this->assertInstanceOf(Money::class, $price);
        $this->assertEquals(1000, $price->getAmount());
        $this->assertEquals('USD', $price->getCurrency()->getCode());
    }

    public function testSetPrice(): void
    {
        $product = new ConcreteProduct('Test Product', 'TP01', 1000, 'usd');
        $product->setPrice(2000, 'eur');
        $price = $product->getPrice();

        $this->assertEquals(2000, $price->getAmount());
        $this->assertEquals('EUR', $price->getCurrency()->getCode());
    }

    public function testSetPriceWithEmptyCurrenyThrowsexception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new ConcreteProduct('Test Product', 'TP01', 1000, 'usd');
        $product->setPrice(2000, '');
    }

    public function testSetNameAndGetName(): void
    {
        $product = new ConcreteProduct('Initial Product', 'P01', 1000, 'usd');
        $this->assertSame('Initial Product', $product->getName());

        $product->setName('Updated Product');
        $this->assertSame('Updated Product', $product->getName());
    }

    public function testSetCodeAndGetCode(): void
    {
        $product = new ConcreteProduct('Test Product', 'P01', 1000, 'usd');
        $this->assertSame('P01', $product->getCode());

        $product->setCode('P02');
        $this->assertSame('P02', $product->getCode());
    }
}
