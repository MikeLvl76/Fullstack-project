<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\NumberSalesByDate;
use App\Repository\LandValueRepository;

class NumberSalesByDateProvider implements ProviderInterface
{
    protected $landValueRepository;

    public function __construct(LandValueRepository $landValueRepository) {
        $this->landValueRepository = $landValueRepository;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $results = $this->landValueRepository->findNumberSalesByDate($uriVariables['type'], $uriVariables['from'], $uriVariables['to']);
        $format = '';
        switch ($uriVariables['type'])
        {
            case 'day':
                $format = 'Y-m-d';
                break;
            case 'month':
                $format = 'Y-m';
                break;
            case 'year':
                $format = 'Y';
                break;
        }
        $items = [];
        foreach ($results as $result)
        {
            $numberSalesByDate = new NumberSalesByDate();
            $numberSalesByDate->setDate(\DateTime::createFromFormat($format, $result['date']));
            $numberSalesByDate->setNumberSales($result['numberSales']);
            array_push($items, $numberSalesByDate);
        }
        return $items;
    }
}
