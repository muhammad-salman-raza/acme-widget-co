<?php

declare(strict_types=1);

namespace AcmeWidgetCo\AcmeSales;

use AcmeWidgetCo\Product\ProductServiceInterface;
use AcmeWidgetCo\Basket\BasketServiceInterface;
use AcmeWidgetCo\Basket\Entity\Basket;
use AcmeWidgetCo\Offer\OfferServiceInterface;
use AcmeWidgetCo\Delivery\DeliveryServiceInterface;
use AcmeWidgetCo\Shared\Entity\BasketInterface;

final readonly class AcmeSalesService implements AcmeSalesServiceInterface
{
    private BasketInterface $basket;

    public function __construct(
        private ProductServiceInterface $productService,
        private BasketServiceInterface $basketService,
        private OfferServiceInterface $offerService,
        private DeliveryServiceInterface $shipmentService
    ) {
        $this->basket = new Basket();
    }

    public function addProduct(string $productCode, int $quantity = 1): void
    {
        $product = $this->productService->fetchProductByCode($productCode);
        if (!$product) {
            throw new \InvalidArgumentException("Unknown product code: $productCode");
        }

        $this->basketService->addProduct($this->basket, $product, $quantity);
    }

    public function getTotal(): string
    {
        $discounts = $this->offerService->calculateDiscounts($this->basket);
        $this->basketService->setDiscounts($this->basket, $discounts);


        $shipments = $this->shipmentService->getShipments();
        if (!empty($shipments)) {
            $this->basketService->setShipment($this->basket, $shipments[0]);
        }

        $grandTotal = $this->basketService->calculateGrandTotal($this->basket);
        if (!$grandTotal) {
            return '$0.00';
        }

        return sprintf('$%.2f', $grandTotal->getAmount() / 100);
    }
}
