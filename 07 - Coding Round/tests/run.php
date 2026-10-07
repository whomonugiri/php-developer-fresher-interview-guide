<?php
declare(strict_types=1);

require dirname(__DIR__) . '/solutions.php';

use function DevNinja\CodingRound\{areAnagrams, balancedBrackets, binarySearch, cartTotalCents, factorial, fibonacci, fibonacciTerms, fizzBuzz, flattenOneLevel, groupByRole, isPalindrome, isPrime, mergeSorted, reverseAscii, secondLargest, sortByValue, twoSum, uniqueInOrder, validEmails, wordFrequency};

function same(mixed $actual, mixed $expected, string $case): void
{
    if ($actual !== $expected) {
        throw new RuntimeException($case . ': expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
    }
}

same(reverseAscii(''), '', 'Empty reverse');
same(reverseAscii('code'), 'edoc', 'Reverse');
same(isPalindrome('A man, a plan, a canal: Panama'), true, 'Punctuation palindrome');
same(isPalindrome('Code'), false, 'Not palindrome');
same(areAnagrams('Listen', 'Silent'), true, 'Anagrams');
same(areAnagrams('aab', 'abb'), false, 'Different counts');
same(factorial(0), 1, 'Zero factorial');
same(factorial(5), 120, 'Factorial');
same(fibonacci(0), 0, 'Fibonacci zero');
same(fibonacci(10), 55, 'Fibonacci ten');
same(isPrime(1), false, 'One not prime');
same(isPrime(29), true, 'Prime');
same(isPrime(49), false, 'Square composite');
same(fizzBuzz(0), [], 'Empty FizzBuzz');
same(fizzBuzz(15)[14], 'FizzBuzz', 'Both divisors');
same(secondLargest([9, 9, 7, 3]), 7, 'Distinct second');
same(secondLargest([-5, -2, -9]), -5, 'Negative values');
same(secondLargest([4, 4]), null, 'No second distinct');
same(twoSum([2, 7, 11], 9), [0, 1], 'Two sum');
same(twoSum([3, 3], 6), [0, 1], 'Two equal values');
same(twoSum([1], 2), null, 'No pair');
same(binarySearch([1, 4, 7, 10], 7), 2, 'Binary search');
same(binarySearch([], 7), null, 'Empty search');
same(wordFrequency('PHP php code'), ['code' => 1, 'php' => 2], 'Frequency');
same(wordFrequency('red blue red'), ['blue' => 1, 'red' => 2], 'Video word count');
same(uniqueInOrder([2, 1, 2, 3]), [2, 1, 3], 'Order-preserving distinct');
same(uniqueInOrder([]), [], 'Empty distinct');
same(sortByValue(['b' => 3, 'a' => 1, 'c' => 3]), ['a' => 1, 'b' => 3, 'c' => 3], 'Stable value sort');
$records = [['name' => 'Ana', 'role' => 'dev'], ['name' => 'Bo', 'role' => 'qa'], ['name' => 'Cy', 'role' => 'dev']];
same(groupByRole($records), ['dev' => [$records[0], $records[2]], 'qa' => [$records[1]]], 'Group by role');
same(flattenOneLevel([[1, 2], [], [3]]), [1, 2, 3], 'One-level flatten');
same(validEmails(['a@example.test', 'bad', 'b@example.test']), ['a@example.test', 'b@example.test'], 'Email syntax filter');
same(cartTotalCents([['price_cents' => 199, 'quantity' => 2], ['price_cents' => 50, 'quantity' => 1]]), 448, 'Cart integer money');
same(cartTotalCents([]), 0, 'Empty cart');
same(fibonacciTerms(7), [0, 1, 1, 2, 3, 5, 8], 'First seven Fibonacci terms');
same(fibonacciTerms(0), [], 'No Fibonacci terms');
same(mergeSorted([1, 3, 5], [2, 4, 6]), [1, 2, 3, 4, 5, 6], 'Merge sorted');
same(mergeSorted([], [1, 1]), [1, 1], 'Merge empty side');
same(balancedBrackets('({[]})'), true, 'Nested brackets');
same(balancedBrackets('([)]'), false, 'Crossed brackets');
same(balancedBrackets('('), false, 'Unclosed bracket');
echo "Part 7 edge-case checks passed.\n";
