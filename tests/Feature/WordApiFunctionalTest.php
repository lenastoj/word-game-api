<?php

namespace Tests\Feature;

use Tests\TestCase;

class WordApiFunctionalTest extends TestCase
{

    public function testValidWord(): void
    {
        $word = 'mom';
        $response = $this->get("/api/game/{$word}");

        $response->assertStatus(200);
        dump("Response for valid word {$word}: " . $response->getContent());
    }

    public function testInvalidWord(): void
    {
        $word = 'mommaa';
        $response = $this->get("/api/game/{$word}");

        $response->assertStatus(404);
        dump("Response for invalid word {$word}: " . $response->getContent());
    }
}
