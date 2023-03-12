<?php

namespace App\Repository;

use App\Entity\LandValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class LandValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, RequestStack $requestStack)
    {
        parent::__construct($registry, LandValue::class);
        $this->requestStack = $requestStack;
    }

    public function findAveragePricePerMonth()
    {
        $queryBuilder = $this->createQueryBuilder('lv')
            ->select('DATE_FORMAT(lv.mutationDate, :format) as date,
            AVG(lv.landValue / lv.actualBuiltUpArea) as averagePrice')
            ->where('lv.mutationType = :sale')
            ->andWhere('lv.localType IN (:apartment, :house)')
            ->andWhere('lv.landValue > 0')
            ->andWhere('lv.actualBuiltUpArea > 0')
            ->setParameter('format', 'YYYY-MM')
            ->setParameter('sale', 'Vente')
            ->setParameter('apartment', 'Appartement')
            ->setParameter('house', 'Maison')
            ->groupBy('date')
            ->orderBy('date');
        return $queryBuilder->getQuery()->getResult();
    }

    public function findSalesByRegion(int $year)
    {
        $queryBuilder = $this->createQueryBuilder('lv')
            ->select('lv.region as region,
            COUNT(lv.mutationType) as numberSales')
            ->where('DATE_FORMAT(lv.mutationDate, :format) = :year')
            ->andWhere('lv.mutationType = :sale')
            ->setParameter('format', 'YYYY')
            ->setParameter('year', $year)
            ->setParameter('sale', 'Vente')
            ->groupBy('region')
            ->orderBy('numberSales');
        return $queryBuilder->getQuery()->getResult();
    }

    public function findNumberSalesByDate(string $type, string $startDate, string $endDate)
    {
        $format = '';
        switch ($type)
        {
            case 'day':
                $format = 'YYYY-MM-DD';
                break;
            case 'month':
                $format = 'YYYY-MM';
                break;
            case 'year':
                $format = 'YYYY';
                break;
        }
        $queryBuilder = $this->createQueryBuilder('lv')
            ->select('DATE_FORMAT(lv.mutationDate, :format) as date,
            COUNT(lv.mutationType) as numberSales')
            ->where('lv.mutationType = :sale')
            ->andWhere('lv.mutationDate BETWEEN :startDate AND :endDate')
            ->setParameter('format', $format)
            ->setParameter('sale', 'Vente')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy('date')
            ->orderBy('date');
        return $queryBuilder->getQuery()->getResult();
    }
}
