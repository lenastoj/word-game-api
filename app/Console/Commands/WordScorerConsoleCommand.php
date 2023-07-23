<?php

namespace App\Console\Commands;

use App\Http\Controllers\WordController;
use Illuminate\Console\Command;

class WordScorerConsoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'score:word {word}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Score a word using the WordController API';

    /**
     * Execute the console command.
     */
    public function handle(WordController $wordController)
    {
        $word = $this->argument('word');
        $response = $wordController->scoreWord($word);

        if ($response->getStatusCode() === 200) {
            $responseData = json_decode($response->getContent(), true);
            $this->info("Scores for '{$word}':");
            $this->info("Unique letters: {$responseData['uniqueLetters']}");
            $this->info("Almost palindrome: {$responseData['almostPalindrome']}");
            $this->info("Palindrome: {$responseData['palindrome']}");
            $this->info("Total Score: {$responseData['total']}");
        } else {
            $this->error("Error: {$response->getContent()}");
        }
    }
}
