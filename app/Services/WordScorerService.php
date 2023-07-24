<?php

namespace App\Services;

class WordScorerService
{
  private int $uniqueLetters = 0;
  private int $almostPalindrome = 0;
  private int $palindrome = 0;
  private int $total = 0;

  private function setUniqueLetters(string $word)
  {
    $this->uniqueLetters = count(array_unique(str_split($word)));
  }

  private function setAlmostPalindrome(string $word)
  {
    for ($i = 0; $i < strlen($word); $i++) {
      $tempWord = substr_replace($word, '', $i, 1);
      if (strrev($tempWord) === $tempWord) {
        $this->almostPalindrome = 2;
      };
    }
  }

  private function setPalindrome(string $word)
  {
    $reversedWord = strrev($word);
    $word === $reversedWord &&  $this->palindrome = 3;
  }

  public function getTotal(string $word): array
  {
    $this->setUniqueLetters($word);
    $this->setPalindrome($word);
    $this->palindrome ?: $this->setAlmostPalindrome($word);
    $this->total = $this->uniqueLetters + $this->almostPalindrome + $this->palindrome;
    return $result = ['word' => $word, 'uniqueLetters' => $this->uniqueLetters, 'almostPalindrome' => $this->almostPalindrome, 'palindrome' => $this->palindrome, 'total' => $this->total];
  }
}
