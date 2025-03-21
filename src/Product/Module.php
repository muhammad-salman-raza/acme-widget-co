<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product;

use AcmeWidgetCo\ModuleInterface;
use AcmeWidgetCo\Product\Repository\ProductRepository;
use AcmeWidgetCo\Product\Repository\ProductRepositoryInterface;
use DI;

class Module implements ModuleInterface
{
    public function getDefinitions(): array
    {
        return [
            ProductRepositoryInterface::class => DI\create(ProductRepository::class),
            ProductServiceInterface::class => DI\create(ProductService::class)
                ->constructor(DI\get(ProductRepositoryInterface::class)),
        ];
    }
}
