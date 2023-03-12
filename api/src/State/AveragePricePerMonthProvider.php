<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\AveragePricePerMonth;
use App\Repository\LandValueRepository;

class AveragePricePerMonthProvider implements ProviderInterface
{
    protected $landValueRepository;

    public function __construct(LandValueRepository $landValueRepository) {
        $this->landValueRepository = $landValueRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $results = $this->landValueRepository->findAveragePricePerMonth();
        $items = [];
        foreach ($results as $result)
        {
            $averagePricePerMonth = new AveragePricePerMonth();
            $averagePricePerMonth->setDate(\DateTime::createFromFormat('Y-m', $result['date']));
            $averagePricePerMonth->setAveragePrice($result['averagePrice']);
            array_push($items, $averagePricePerMonth);
        }
        return $items;
    }
}
