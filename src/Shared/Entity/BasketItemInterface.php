<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Shared\Entity;

interface BasketItemInterface
{
    public function getProduct(): ProductInterface;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;
}
