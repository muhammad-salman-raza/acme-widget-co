<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Repository;

use AcmeWidgetCo\Product\Entity\ConcreteProduct;
use AcmeWidgetCo\Shared\Entity\ProductInterface;

readonly class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @return array<ProductInterface>
     */
    public function getAllProducts(): array
    {
        return [
            new ConcreteProduct('Red Widget', 'R01', 3295, 'USD'),
            new ConcreteProduct('Green Widget', 'G01', 2495, 'USD'),
            new ConcreteProduct('Blue Widget', 'B01', 795, 'USD'),
        ];
    }

    public function getProductByCode(string $code): ?ProductInterface
    {
        foreach ($this->getAllProducts() as $product) {
            if ($product->getCode() === $code) {
                return $product;
            }
        }

        return null;
    }
}
