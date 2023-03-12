<?php

use PHPUnit\Framework\TestCase;
use App\State\AveragePricePerMonthProvider;
use App\Entity\AveragePricePerMonth;
use ApiPlatform\Metadata\Operation;
use App\Repository\LandValueRepository;
class AveragePricePerMonthProviderTest extends TestCase
{
    public function testProvide()
    {
        // Create a mock repository
        $repository = $this->createMock(LandValueRepository::class);

        // Set up the mock repository to return some test data when findAveragePricePerMonth() is called
        $repository->expects($this->once())
            ->method('findAveragePricePerMonth')
            ->willReturn([
                ['date' => '2021-01', 'averagePrice' => 123456],
                ['date' => '2021-03', 'averagePrice' => 123457],
            ]);

        // Create an instance of the provider and call the provide() method
        $provider = new AveragePricePerMonthProvider($repository);
        $operation = $this->createMock(Operation::class);
        $items = $provider->provide($operation);

        // Assert that the returned data is as expected
        $this->assertCount(2, $items);
        $this->assertContainsOnlyInstancesOf(AveragePricePerMonth::class, $items);
        $this->assertEquals('2021-01', $items[0]->getDate()->format('Y-m'));
        $this->assertEquals(123456, $items[0]->getAveragePrice());
        $this->assertEquals('2021-03', $items[1]->getDate()->format('Y-m'));
        $this->assertEquals(123457, $items[1]->getAveragePrice());

    }
}

?>
