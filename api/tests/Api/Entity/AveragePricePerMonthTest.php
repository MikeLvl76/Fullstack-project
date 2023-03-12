<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\AveragePricePerMonth;

class AveragePricePerMonthTest extends TestCase
{
    public function testGettersAndSetters()
    {
        // Create an instance of the AveragePricePerMonth class
        $averagePricePerMonth = new AveragePricePerMonth();

        // Set the date and average price using the setters
        $date = new \DateTime();
        $averagePrice = 123.45;
        $averagePricePerMonth->setDate($date);
        $averagePricePerMonth->setAveragePrice($averagePrice);

        // Verify that the getters return the correct values
        $this->assertEquals($date, $averagePricePerMonth->getDate());
        $this->assertEquals($averagePrice, $averagePricePerMonth->getAveragePrice());
    }
    public function testGetRequest()
    {
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://caddy/average_price_per_month?page=1', [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('averagePrice', $response->getContent());
        $this->assertStringContainsString('date', $response->getContent());
    }
}
