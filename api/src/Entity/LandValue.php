<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\LandValueRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

#[ApiResource]
#[Entity(repositoryClass: LandValueRepository::class)]
#[ApiFilter(DateFilter::class, properties: ['mutationDate'])]
#[ApiFilter(SearchFilter::class, properties: ['mutationType' => 'exact', 'localType' => 'exact', 'region' => 'exact'])]
#[ApiFilter(RangeFilter::class, properties: ['landValue', 'actualBuiltUpArea'])]
class LandValue
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: 'integer')]
    // The identifier of this land
    protected int $identifier;

    #[Column(type: 'date')]
    // The mutation date of this land
    protected \DateTime $mutationDate;

    #[Column(type: 'string')]
    // The mutation type of this land
    protected string $mutationType;

    #[Column(type: 'float')]
    #[PositiveOrZero]
    // The value of this land
    protected float $landValue;

    #[Column(type: 'string', nullable: true)]
    // The local type of this land
    protected ?string $localType;

    #[Column(type: 'integer', nullable: true)]
    #[PositiveOrZero]
    // The actual built up area of this land
    protected ?int $actualBuiltUpArea;

    #[Column(type: 'string')]
    // The region of this land
    protected string $region;

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function getMutationDate(): \DateTime
    {
        return $this->mutationDate;
    }

    public function getMutationType(): string
    {
        return $this->mutationType;
    }

    public function getLandValue(): float
    {
        return $this->landValue;
    }

    public function getLocalType(): string
    {
        return $this->localType;
    }

    public function getActualBuiltUpArea()
    {
        return $this->actualBuiltUpArea;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function setMutationDate(\DateTime $mutationDate): void
    {
        $this->mutationDate = $mutationDate;
    }

    public function setMutationType(string $mutationType): void
    {
        $this->mutationType = $mutationType;
    }

    public function setLandValue(float $landValue): void
    {
        $this->landValue = $landValue;
    }

    public function setLocalType(string $localType): void
    {
        $this->localType = $localType;
    }

    public function setActualBuiltUpArea(int $actualBuiltUpArea): void
    {
        $this->actualBuiltUpArea = $actualBuiltUpArea;
    }

    public function setRegion(string $region): void
    {
        $this->region = $region;
    }
}
