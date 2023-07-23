<?php

namespace Tests\Unit;

use App\Services\DictionaryApiService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;
use Tests\TestCase;

class DictionaryApiServiceTest extends TestCase
{
    private function createMockHttpClient(array $responses): Client
    {
        $mockHandler = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mockHandler);
        return new Client(['handler' => $handlerStack]);
    }

    public function testGetWordWithValidWord(): void
    {
        $word = 'apple';
        $responseData = [
            ['word' => 'apple']
        ];

        $httpClient = $this->createMockHttpClient([
            new Response(200, [], json_encode($responseData)),
        ]);

        $dictionaryApiService = new DictionaryApiService($httpClient);
        $result = $dictionaryApiService->getWord($word);

        $this->assertTrue($result);
    }

    public function testGetWordWithInvalidWord(): void
    {
        $word = 'aplee';

        $httpClient = $this->createMockHttpClient([
            new RequestException('Error Communicating with Server', new \GuzzleHttp\Psr7\Request('GET', 'test')),
        ]);

        $dictionaryApiService = new DictionaryApiService($httpClient);
        $result = $dictionaryApiService->getWord($word);

        $this->assertFalse($result);
    }
}
