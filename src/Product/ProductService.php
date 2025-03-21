<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product;

use AcmeWidgetCo\Product\Repository\ProductRepositoryInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;

readonly class ProductService implements ProductServiceInterface
{
    public function __construct(private ProductRepositoryInterface $repository)
    {
    }

    public function fetchAllProducts(): array
    {
        return $this->repository->getAllProducts();
    }

    public function fetchProductByCode(string $code): ?ProductInterface
    {
        return $this->repository->getProductByCode($code);
    }
}
