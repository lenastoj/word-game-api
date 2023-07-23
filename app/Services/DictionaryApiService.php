<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class DictionaryApiService
{
    private $client;
    private $baseURL;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->baseURL = env('BASE_URL') ?? 'https://api.dictionaryapi.dev/api/v2/entries/en/';
    }

    public function getWord(string $word): bool
    {
        try {
            $response = $this->client->get($this->baseURL . $word);
            $data = json_decode($response->getBody(), true);

            return !empty($data) && $data[0]['word'] === $word;
        } catch (RequestException $error) {
            Log::error('Dictionary API Error: ' . $error->getMessage());
            return false;
        }
    }
}
