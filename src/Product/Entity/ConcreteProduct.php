<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Product\Entity;

use AcmeWidgetCo\Shared\Entity\ProductInterface;
use Money\Currency;
use Money\Money;
use Webmozart\Assert\Assert;

final class ConcreteProduct extends AbstractProduct implements ProductInterface
{
    private int $priceAmount;
    private string $priceCurrency;

    public function __construct(
        string $name,
        public string $code,
        int $amount,
        string $currency
    ) {
        parent::__construct($name);
        $this->setPrice($amount, $currency);
    }

    public function getPrice(): Money
    {
        Assert::stringNotEmpty($this->priceCurrency, 'Currency must not be empty.');

        return new Money($this->priceAmount, new Currency($this->priceCurrency));
    }

    public function setPrice(int $amount, string $currency): void
    {
        Assert::stringNotEmpty($currency, 'Currency cannot be empty.');

        $this->priceAmount = $amount;
        $this->priceCurrency = strtoupper($currency);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
