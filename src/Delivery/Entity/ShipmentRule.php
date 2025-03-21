<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Entity;

use Money\Money;
use Money\Currency;
use Webmozart\Assert\Assert;

use function strtoupper;

final readonly class ShipmentRule
{
    public function __construct(
        private int $minThreshold,
        private ?int $maxThreshold,
        private int $fee,
        private string $currency,
    ) {
    }

    public function appliesTo(int $orderAmount): bool
    {
        if ($orderAmount < $this->minThreshold) {
            return false;
        }
        if ($this->maxThreshold !== null && $orderAmount >= $this->maxThreshold) {
            return false;
        }
        return true;
    }

    public function getFee(): Money
    {
        Assert::notEmpty($this->currency);

        return new Money($this->fee, new Currency(strtoupper($this->currency)));
    }
}
