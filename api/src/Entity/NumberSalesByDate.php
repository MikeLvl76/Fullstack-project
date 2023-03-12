<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\NumberSalesByDateProvider;

#[ApiResource(operations: [
    new GetCollection(
        uriTemplate: 'number_sales_by_date/{type}/{from}/{to}',
        openapiContext: [
            'parameters' => [
                [
                    'name' => 'type',
                    'in' => 'path',
                    'required' => true,
                    'schema' => [
                        'type' => 'string',
                        'enum' => ['day', 'month', 'year']
                    ],
                    'description' => 'The way in which the number of sales should be grouped'
                ],
                [
                    'name' => 'from',
                    'in' => 'path',
                    'required' => true,
                    'schema' => [
                        'type' => 'string',
                        'format' => 'date',
                    ],
                    'example' => '2021-01-12',
                    'description' => 'The starting date of the date range, in the format "YYYY-MM-DD"'
                ],
                [
                    'name' => 'to',
                    'in' => 'path',
                    'required' => true,
                    'schema' => [
                        'type' => 'string',
                        'format' => 'date',
                    ],
                    'example' => '2021-12-31',
                    'description' => 'The ending date of the date range, in the format "YYYY-MM-DD"'
                ]
            ]
        ],
        provider: NumberSalesByDateProvider::class,
        description: 'Retrieves the number of sales between two dates (day, month, year)'
    )
])]

class NumberSalesByDate
{
    // The date (day, month, year)
    protected \DateTime $date;

    // The number of sales for this date
    protected int $numberSales;

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getNumberSales(): int
    {
        return $this->numberSales;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function setNumberSales(int $numberSales): void
    {
        $this->numberSales = $numberSales;
    }
}
