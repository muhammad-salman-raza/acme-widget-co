<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Offer;

use AcmeWidgetCo\ModuleInterface;
use AcmeWidgetCo\Offer\Plugin\BuyOneGetSecondHalfPriceOffer;
use DI;

class Module implements ModuleInterface
{
    public function getDefinitions(): array
    {
        return [
            'offer.offers' => [
                DI\create(BuyOneGetSecondHalfPriceOffer::class),
                // Additional offer plugins can be added here.
            ],
            OfferServiceInterface::class => DI\autowire(OfferService::class)
                ->constructorParameter('offers', DI\get('offer.offers')),
        ];
    }
}
