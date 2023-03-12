<?php
use PHPUnit\Framework\TestCase;
use App\State\SalesByRegionProvider;
use App\Entity\SalesByRegion;
use ApiPlatform\Metadata\Operation;
use App\Repository\LandValueRepository;

class SalesByRegionProviderTest extends TestCase
{
    public function testProvide()
    {
        // Create a mock repository
        $repository = $this->createMock(LandValueRepository::class);

        // Set up the mock repository to return some test data when findSalesByRegion() is called
        $repository->expects($this->once())
            ->method('findSalesByRegion')
            ->with(2021)
            ->willReturn([
                ['region' => 'Auvergne-Rhône-Alpes', 'numberSales' => 123456],
                ['region' => 'Normandie', 'numberSales' => 123457],
            ]);

        // Create an instance of the provider and call the provide() method
        $provider = new SalesByRegionProvider($repository);
        $operation = $this->createMock(Operation::class);
        $items = $provider->provide($operation, ['year' => 2021]);

        // Assert that the returned data is as expected
        $this->assertCount(2, $items);
        $this->assertContainsOnlyInstancesOf(SalesByRegion::class, $items);
        $this->assertEquals('Auvergne-Rhône-Alpes', $items[0]->getRegion());
        $this->assertEquals(123456, $items[0]->getNumberSales());
        $this->assertEquals('Normandie', $items[1]->getRegion());
        $this->assertEquals(123457, $items[1]->getNumberSales());

    }
}


?>