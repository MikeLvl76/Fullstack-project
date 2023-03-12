<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\SalesByRegion;

class SalesByRegionTest extends TestCase
{
    public function testGettersAndSetters()
    {
        // Create an instance of the SalesByRegion class
        $salesByRegion = new SalesByRegion();

        // Set the region and number of sales using the setters
        $region = 'Normandie';
        $numberSales = 123;
        $salesByRegion->setRegion($region);
        $salesByRegion->setNumberSales($numberSales);

        // Verify that the getters return the correct values
        $this->assertEquals($region, $salesByRegion->getRegion());
        $this->assertEquals($numberSales, $salesByRegion->getNumberSales());
    }
    public function testGetRequest()
    {
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://caddy/sales_by_region/2021?page=1', [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('numberSales', $response->getContent());
    }
}

?>