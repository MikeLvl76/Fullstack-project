<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\AveragePricePerMonthProvider;

#[ApiResource(operations: [
    new GetCollection(
        uriTemplate: 'average_price_per_month',
        provider: AveragePricePerMonthProvider::class,
        description: 'Retrieves the average price per square meter for a given month'
    )
])]
class AveragePricePerMonth
{
    // The date (month)
    protected \DateTime $date;

    // The average price for this date
    protected float $averagePrice;

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getAveragePrice(): float
    {
        return $this->averagePrice;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function setAveragePrice(float $averagePrice): void
    {
        $this->averagePrice = $averagePrice;
    }
}
