<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\WordController;
use App\Services\DictionaryApiService;
use App\Services\WordScorerService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class WordControllerTest extends TestCase
{
    private WordController $wordController;
    private $mockDictionaryApiService, $mockWordScorerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockDictionaryApiService = Mockery::mock(DictionaryApiService::class);
        $this->mockWordScorerService = Mockery::mock(WordScorerService::class);

        $this->wordController = new WordController($this->mockDictionaryApiService, $this->mockWordScorerService);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testScoreWordWithValidWord(): void
    {
        $word = 'apple';

        $this->mockDictionaryApiService->shouldReceive('getWord')->with($word)->andReturn(true);
        $this->mockWordScorerService->shouldReceive('getTotal')->with($word)->andReturn(['uniqueLetters' => 4, 'almostPalindrome' => 0, 'palindrome' => 0, 'total' => 4]);

        $response = $this->wordController->scoreWord($word);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testScoreWordWithInvalidWord(): void
    {
        $word = 'aplee';

        $this->mockDictionaryApiService->shouldReceive('getWord')->with($word)->andReturn(false);

        $response = $this->wordController->scoreWord($word);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
