<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product;

use AcmeWidgetCo\Shared\Entity\ProductInterface;

interface ProductServiceInterface
{
    /**
     * @return array<ProductInterface>
     */
    public function fetchAllProducts(): array;

    public function fetchProductByCode(string $code): ?ProductInterface;
}
