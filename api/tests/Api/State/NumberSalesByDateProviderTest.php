<?php

use PHPUnit\Framework\TestCase;
use App\State\NumberSalesByDateProvider;
use App\Entity\NumberSalesByDate;
use ApiPlatform\Metadata\Operation;
use App\Repository\LandValueRepository;

class NumberSalesByDateProviderTest extends TestCase
{
    public function testProvide()
    {
        // Create a mock repository
        $repository = $this->createMock(LandValueRepository::class);

        // Set up the mock repository to return some test data when findNumberSalesByDate() is called
        $repository->expects($this->once())
            ->method('findNumberSalesByDate')
            ->with('month', '2021-01', '2021-03')
            ->willReturn([
                ['date' => '2021-01', 'numberSales' => 123],
                ['date' => '2021-03', 'numberSales' => 456],
            ]);

        // Create an instance of the provider and call the provide() method
        $provider = new NumberSalesByDateProvider($repository);
        $operation = $this->createMock(Operation::class);
        $items = $provider->provide($operation, ['type' => 'month', 'from' => '2021-01', 'to' => '2021-03']);

        // Assert that the returned data is as expected
        $this->assertCount(2, $items);
        $this->assertContainsOnlyInstancesOf(NumberSalesByDate::class, $items);
        $this->assertEquals('2021-01', $items[0]->getDate()->format('Y-m'));
        $this->assertEquals(123, $items[0]->getNumberSales());
        $this->assertEquals('2021-03', $items[1]->getDate()->format('Y-m'));
        $this->assertEquals(456, $items[1]->getNumberSales());
    }
}




?>