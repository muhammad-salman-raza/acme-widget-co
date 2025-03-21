<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Basket\Entity;

use AcmeWidgetCo\Shared\Entity\BasketItemInterface;
use AcmeWidgetCo\Shared\Entity\ProductInterface;

class BasketItem implements BasketItemInterface
{
    public function __construct(
        private ProductInterface $product,
        private int $quantity
    ) {
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
