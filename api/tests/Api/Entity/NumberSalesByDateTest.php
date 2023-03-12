<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\NumberSalesByDate;

class NumberSalesByDateTest extends TestCase
{
    public function testGettersAndSetters()
    {
        // Create an instance of the NumberSalesByDate class
        $numberSalesByDate = new NumberSalesByDate();

        // Set the date and number of sales using the setters
        $date = new \DateTime();
        $numberSales = 123;
        $numberSalesByDate->setDate($date);
        $numberSalesByDate->setNumberSales($numberSales);

        // Verify that the getters return the correct values
        $this->assertEquals($date, $numberSalesByDate->getDate());
        $this->assertEquals($numberSales, $numberSalesByDate->getNumberSales());
    }
    public function testGetRequest()
    {
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        // create the get request
        $response = $client->request('GET', 'http://caddy/number_sales_by_date/day/2021-01-12/2021-12-31?page=1', [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('date', $response->getContent());
        $this->assertStringContainsString('numberSales', $response->getContent());
    }

}
?>