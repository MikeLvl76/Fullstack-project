<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\SalesByRegionProvider;

#[ApiResource(operations: [
    new GetCollection(
        uriTemplate: 'sales_by_region/{year}',
        openapiContext: [
            'parameters' => [
                [
                    'name' => 'year',
                    'in' => 'path',
                    'required' => true,
                    'schema' => [
                        'type' => 'integer'
                    ],
                    'example' => '2021',
                    'description' => 'The year for which sales data should be retrieved'
                ]
            ]
        ],
        provider: SalesByRegionProvider::class,
        description: 'Retrieves the average price per square meter for a given month'
    )
])]
class SalesByRegion
{
    // The region
    protected string $region;

    // The number of sales for this region
    protected int $numberSales;

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getNumberSales(): int
    {
        return $this->numberSales;
    }

    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    public function setNumberSales(int $numberSales): void
    {
        $this->numberSales = $numberSales;
    }
}
