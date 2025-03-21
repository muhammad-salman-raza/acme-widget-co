<?php

declare(strict_types=1);

namespace AcmeWidgetCo\Tests\Integration;

use AcmeWidgetCo\AcmeSales\AcmeSalesServiceInterface;
use AcmeWidgetCo\Tests\KernelAwareTestCase;

class AcmeSalesIntegrationTest extends KernelAwareTestCase
{
    /**
     * @dataProvider basketDataProvider
     * @param string[] $productCodes
     */
    public function testBaskets(array $productCodes, string $expectedTotal): void
    {
        /** @var AcmeSalesServiceInterface $salesService */
        $salesService = $this->container->get(AcmeSalesServiceInterface::class);

        foreach ($productCodes as $code) {
            $salesService->addProduct($code);
        }

        $actualTotal = $salesService->getTotal();
        $this->assertSame($expectedTotal, $actualTotal, sprintf(
            'Basket with products [%s] should total %s, got %s',
            implode(', ', $productCodes),
            $expectedTotal,
            $actualTotal
        ));
    }

    /**
     * @return array<string, array{0: string[], 1: string}>
     */
    public function basketDataProvider(): array
    {
        return [
            'B01, G01 => $37.85' => [
                ['B01', 'G01'],
                '$37.85',
            ],
            'R01, R01 => $54.37' => [
                ['R01', 'R01'],
                '$54.37',
            ],
            'R01, G01 => $60.85' => [
                ['R01', 'G01'],
                '$60.85',
            ],
            'B01, B01, R01, R01, R01 => $98.27' => [
                ['B01', 'B01', 'R01', 'R01', 'R01'],
                '$98.27',
            ],
        ];
    }

    public function testBasketWithInvalidProductCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        /** @var AcmeSalesServiceInterface $salesService */
        $salesService = $this->container->get(AcmeSalesServiceInterface::class);
        $salesService->addProduct('Invalid_code');
    }

    public function testGrandTotalForEmptyBasket(): void
    {
        /** @var AcmeSalesServiceInterface $salesService */
        $salesService = $this->container->get(AcmeSalesServiceInterface::class);

        $actualTotal = $salesService->getTotal();
        $this->assertSame('$0.00', $actualTotal);
    }
}
