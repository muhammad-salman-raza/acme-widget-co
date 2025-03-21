<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Repository;

use AcmeWidgetCo\Shared\Entity\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * @return array<ProductInterface>
     */
    public function getAllProducts(): array;

    public function getProductByCode(string $code): ?ProductInterface;
}
