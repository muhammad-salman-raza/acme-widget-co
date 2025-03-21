<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Delivery\Plugin\PriceCalculation;

use AcmeWidgetCo\Shared\Entity\BasketInterface;
use Money\Money;
use Money\Currency;
use AcmeWidgetCo\Delivery\Repository\ShipmentRuleRepositoryInterface;

final readonly class StandardPriceCalculationPlugin implements PriceCalculationPluginInterface
{
    public function __construct(
        private ShipmentRuleRepositoryInterface $ruleRepository
    ) {
    }

    public function getPrice(BasketInterface $basket): Money
    {
        $subTotal = $basket->getSubTotal();
        if ($subTotal === null) {
            return new Money(0, new Currency('USD'));
        }

        $discount = $basket->getTotalDiscount();
        $total = $subTotal->subtract($discount);

        $orderAmount = (int)$total->getAmount();
        $currencyCode = $total->getCurrency()->getCode();

        foreach ($this->ruleRepository->getRules() as $rule) {
            if ($rule->appliesTo($orderAmount)) {
                return $rule->getFee();
            }
        }

        return new Money(0, new Currency($currencyCode));
    }
}
