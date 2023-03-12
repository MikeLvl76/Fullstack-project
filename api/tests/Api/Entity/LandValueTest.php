<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\LandValue;
class LandValueTest extends TestCase
{
    public function testGettersAndSetters(){
        // Create an instance of the LandValue class
        $landValues = new LandValue();
        // Set the properties using the setters
        $mutationDate = new \DateTime();
        $mutationType = 'test';
        $landValue = 123.45;
        $localType = 'test';
        $actualBuiltUpArea = 123;
        $region = 'test';

        $landValues->setLandValue($landValue);
        $landValues->setLocalType($localType);
        $landValues->setActualBuiltUpArea($actualBuiltUpArea);
        $landValues->setRegion($region);
        $landValues->setMutationDate($mutationDate);
        $landValues->setMutationType($mutationType);
        // Verify that the getters return the correct values
        $this->assertEquals($mutationDate, $landValues->getMutationDate());
        $this->assertEquals($mutationType, $landValues->getMutationType());
        $this->assertEquals($landValue, $landValues->getLandValue());
        $this->assertEquals($localType, $landValues->getLocalType());
        $this->assertEquals($actualBuiltUpArea, $landValues->getActualBuiltUpArea());
        $this->assertEquals($region, $landValues->getRegion());
    }
    public function getIdentifiers(){
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://caddy/land_values?page=1', [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // get all the identifiers of the land values
        $identifiers = json_decode($response->getContent(), true)['hydra:member'];
        // cast them to int 
        $identifiers = array_map(function($identifier){
            return (int) $identifier['identifier'];
        }, $identifiers);
        return $identifiers;
    }
    public function testGetRequest()
    {
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://caddy/land_values?page=1', [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('landValue', $response->getContent());
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('localType', $response->getContent());
        $this->assertStringContainsString('actualBuiltUpArea', $response->getContent());
        $this->assertStringContainsString('mutationType', $response->getContent());
        $this->assertStringContainsString('mutationDate', $response->getContent());


    }
    public function testPostRequest()
    {
        // Create a client and send a POST request to the API
        $client = HttpClient::create();
        $response = $client->request('POST', 'http://caddy/land_values?page=1', [
            'headers' => ['accept' => 'application/ld+json'],
            'json' => [
                'landValue' => random_int(1,10000000),
                'region' => "Auvergne-Rhône-Alpes",
                'localType' => 'string',
                'actualBuiltUpArea' => random_int(1,100000),
                'mutationType' => 'string',
                'mutationDate' => '2022-12-29T20:53:40.227Z'
            ]
        ]);
        // Assert that the response is successful
        $this->assertEquals(201, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('landValue', $response->getContent());
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('localType', $response->getContent());
        $this->assertStringContainsString('actualBuiltUpArea', $response->getContent());
        $this->assertStringContainsString('mutationType', $response->getContent());
        $this->assertStringContainsString('mutationDate', $response->getContent());

    }
    public function testGetRequestWithIdentifier()
    {
        $identifiers = $this->getIdentifiers();
        $identifier = $identifiers[array_rand($identifiers)];
        // Create a client and send a GET request to the API
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://caddy/land_values/'.$identifier, [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('landValue', $response->getContent());
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('localType', $response->getContent());
        $this->assertStringContainsString('actualBuiltUpArea', $response->getContent());
        $this->assertStringContainsString('mutationType', $response->getContent());
        $this->assertStringContainsString('mutationDate', $response->getContent());
    }
    public function testPutRequest()
    {
        $identifiers = $this->getIdentifiers();
        $identifier = $identifiers[array_rand($identifiers)];
        // Create a client and send a PUT request to the API
        $client = HttpClient::create();
        $response = $client->request('PUT', 'http://caddy/land_values/'.$identifier, [
            'headers' => ['accept' => 'application/ld+json'],
            'json' => [
                'landValue' => random_int(1,10000000),
                'region' => "Auvergne-Rhône-Alpes",
                'localType' => 'string',
                'actualBuiltUpArea' => random_int(1,100000),
                'mutationType' => 'string',
                'mutationDate' => '2022-12-29T20:53:40.227Z'
            ]
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('landValue', $response->getContent());
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('localType', $response->getContent());
        $this->assertStringContainsString('actualBuiltUpArea', $response->getContent());
        $this->assertStringContainsString('mutationType', $response->getContent());
        $this->assertStringContainsString('mutationDate', $response->getContent());
    }
    public function testDeleteRequest()
    {
        
        $identifiers = $this->getIdentifiers();
        $identifier = $identifiers[array_rand($identifiers)];
        // Create a client and send a DELETE request to the API
        $client = HttpClient::create();
        $response = $client->request('DELETE', 'http://caddy/land_values/'.$identifier, [
            'headers' => ['accept' => 'application/ld+json']
        ]);
        // Assert that the response is successful
        $this->assertEquals(204, $response->getStatusCode());
    }
    public function testPatchRequest()
    {
        $identifiers = $this->getIdentifiers();
        $identifier = $identifiers[array_rand($identifiers)];
        // Create a client and send a PATCH request to the API
        $client = HttpClient::create();
        $response = $client->request('PATCH', 'http://caddy/land_values/'.$identifier, [
            'headers' => ['Content-Type' => 'application/merge-patch+json','accept' => 'application/ld+json'],
            'json' => [
                'landValue' => random_int(1,10000000),
                'region' => "Auvergne-Rhône-Alpes",
                'localType' => 'string',
                'actualBuiltUpArea' => random_int(1,100000),
                'mutationType' => 'string',
                'mutationDate' => '2022-12-29T20:53:40.227Z'
            ]
        ]);
        // Assert that the response is successful
        $this->assertEquals(200, $response->getStatusCode());
        // Assert that the response is in JSON
        $this->assertStringContainsString('application/ld+json', $response->getHeaders()['content-type'][0]);
        // Assert that the response contains the expected properties
        $this->assertStringContainsString('landValue', $response->getContent());
        $this->assertStringContainsString('region', $response->getContent());
        $this->assertStringContainsString('localType', $response->getContent());
        $this->assertStringContainsString('actualBuiltUpArea', $response->getContent());
        $this->assertStringContainsString('mutationType', $response->getContent());
        $this->assertStringContainsString('mutationDate', $response->getContent());
    }
}
?>