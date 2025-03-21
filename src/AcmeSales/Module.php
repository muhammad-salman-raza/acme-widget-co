<?php

declare(strict_types=1);

namespace AcmeWidgetCo\AcmeSales;

use AcmeWidgetCo\ModuleInterface;
use DI;

class Module implements ModuleInterface
{
    public function getDefinitions(): array
    {
        return [
            AcmeSalesServiceInterface::class => DI\autowire(AcmeSalesService::class)
        ];
    }
}
