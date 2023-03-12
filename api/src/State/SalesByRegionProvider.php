<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\SalesByRegion;
use App\Repository\LandValueRepository;

class SalesByRegionProvider implements ProviderInterface
{
    protected $landValueRepository;

    public function __construct(LandValueRepository $landValueRepository) {
        $this->landValueRepository = $landValueRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $results = $this->landValueRepository->findSalesByRegion($uriVariables['year']);
        $items = [];
        foreach ($results as $result)
        {
            $salesByRegion = new SalesByRegion();
            $salesByRegion->setRegion($result['region']);
            $salesByRegion->setNumberSales($result['numberSales']);
            array_push($items, $salesByRegion);
        }
        return $items;
    }
}
