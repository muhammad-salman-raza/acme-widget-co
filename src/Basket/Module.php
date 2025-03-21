<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket;

use AcmeWidgetCo\ModuleInterface;
use DI;

class Module implements ModuleInterface
{
    public function getDefinitions(): array
    {
        return [
            BasketServiceInterface::class => DI\create(BasketService::class),
        ];
    }
}
