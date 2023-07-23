<?php

namespace App\Http\Controllers;

use App\Services\DictionaryApiService;
use App\Services\WordScorerService;
use Illuminate\Http\JsonResponse;

class WordController extends Controller
{
    private $dictionaryApiService, $wordScorerService;

    public function __construct(DictionaryApiService $dictionaryApiService, WordScorerService $wordScorerService)
    {
        $this->dictionaryApiService = $dictionaryApiService;
        $this->wordScorerService = $wordScorerService;
    }

    public function scoreWord(string $string): JsonResponse
    {
        $word = str_replace(' ', '', strtolower($string));
        $wordExists = $this->dictionaryApiService->getWord($word);

        return $wordExists ? response()->json($this->wordScorerService->getTotal($word)) : response()->json($data = "This word does not exist in English Dictionary", $status = 404);
    }
}
