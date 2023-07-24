<?php

namespace Tests\Unit;

use App\Services\WordScorerService;
use Tests\TestCase;

class WordScorerServiceTest extends TestCase
{
    private WordScorerService $wordScorerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->wordScorerService = new WordScorerService();
    }

    public function wordScoresDataProvider(): array
    {
        return [
            ['apple', ['word' => 'apple', 'uniqueLetters' => 4, 'almostPalindrome' => 0, 'palindrome' => 0, 'total' => 4]],
            ['banana', ['word' => 'banana', 'uniqueLetters' => 3, 'almostPalindrome' => 2, 'palindrome' => 0, 'total' => 5]],
            ['radar', ['word' => 'radar', 'uniqueLetters' => 3, 'almostPalindrome' => 0, 'palindrome' => 3, 'total' => 6]],
            ['mom', ['word' => 'mom', 'uniqueLetters' => 2, 'almostPalindrome' => 0, 'palindrome' => 3, 'total' => 5]],

        ];
    }

    /**
     * @dataProvider wordScoresDataProvider
     */
    public function testGetTotal(string $word, array $expectedResult): void
    {
        $result = $this->wordScorerService->getTotal($word);

        $this->assertEquals($expectedResult, $result);
    }
}
