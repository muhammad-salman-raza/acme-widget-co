<?php

declare(strict_types=1);

namespace AcmeWidgetCo\AcmeSales;

interface AcmeSalesServiceInterface
{
    public function addProduct(string $productCode, int $quantity = 1): void;

    public function getTotal(): string;
}
