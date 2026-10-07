<?php
declare(strict_types=1);

require __DIR__ . '/solutions.php';

use function DevNinja\CodingRound\{cartTotalCents, factorial, fibonacciTerms, fizzBuzz, flattenOneLevel, groupByRole, isPalindrome, isPrime, mergeSorted, reverseAscii, secondLargest, sortByValue, twoSum, uniqueInOrder, validEmails, wordFrequency};

echo '01 reverse: ' . reverseAscii('hello') . PHP_EOL;
echo '02 palindrome: ' . (isPalindrome('Racecar') ? 'true' : 'false') . PHP_EOL;
echo '03 word counts: ' . json_encode(wordFrequency('red blue red'), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '04 unique: ' . json_encode(uniqueInOrder([2, 1, 2, 3]), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '05 second distinct largest: ' . secondLargest([7, 3, 7, 5]) . PHP_EOL;
echo '06 sorted scores: ' . json_encode(sortByValue(['b' => 3, 'a' => 1, 'c' => 3]), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '07 grouped roles: ' . json_encode(groupByRole([['name' => 'Ana', 'role' => 'dev'], ['name' => 'Bo', 'role' => 'qa'], ['name' => 'Cy', 'role' => 'dev']]), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '08 flattened: ' . json_encode(flattenOneLevel([[1, 2], [3]]), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '09 valid emails: ' . json_encode(validEmails(['a@example.test', 'bad', 'b@example.test']), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '10 cart cents: ' . cartTotalCents([['price_cents' => 199, 'quantity' => 2], ['price_cents' => 50, 'quantity' => 1]]) . PHP_EOL;
echo '11 FizzBuzz 1..15: ' . implode(', ', fizzBuzz(15)) . PHP_EOL;
echo '12 29 prime: ' . (isPrime(29) ? 'true' : 'false') . PHP_EOL;
echo '13 5!: ' . factorial(5) . PHP_EOL;
echo '14 first 7 Fibonacci: ' . implode(', ', fibonacciTerms(7)) . PHP_EOL;
echo '15 merged: ' . json_encode(mergeSorted([1, 3, 5], [2, 4, 6]), JSON_THROW_ON_ERROR) . PHP_EOL;
echo '16 two sum indices: ' . implode(', ', twoSum([2, 7, 11], 9)) . PHP_EOL;
