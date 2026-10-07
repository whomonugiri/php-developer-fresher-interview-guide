# Part 7 — Coding Round

Practice explaining a solution **before** writing it: input/output, edge cases, approach, time and space complexity, then a small test. The functions in [`solutions.php`](solutions.php) are independent and use PHP 8.1+ type declarations. Run:

```powershell
C:\xampp\php\php.exe run.php
C:\xampp\php\php.exe tests\run.php
```

| # | Worked problem and sample | Main idea | Complexity |
| ---: | --- | --- | --- |
| 01 | Reverse `hello` → `olleh` | `strrev()` on ASCII bytes | O(n) time and output |
| 02 | `Racecar` is a palindrome | Normalize case/punctuation, compare reversed text | O(n) time and space |
| 03 | `red blue red` → red 2, blue 1 | Extract ASCII words and count | O(n + k log k) with sorted keys |
| 04 | `[2,1,2,3]` → `[2,1,3]` | Record seen integers, preserve first occurrence | O(n) expected time and space |
| 05 | `[7,3,7,5]` → second distinct is 5 | Track two distinct maxima | O(n) time, O(1) space |
| 06 | Sort an associative score array by value | Stable `uasort()` in PHP 8 | O(n log n) time |
| 07 | Group users by `role` | Append to a map of lists | O(n) expected time and space |
| 08 | `[[1,2],[3]]` → `[1,2,3]` | Copy one nesting level | O(n) time and output |
| 09 | Keep valid email strings | `filter_var()` checks syntax only | O(n) checks and output |
| 10 | Cart total in integer cents | Sum price × quantity with overflow checks | O(n) time, O(1) extra space |
| 11 | FizzBuzz 1–15 | Apply the combined 15 rule first | O(n) time and output |
| 12 | Is 29 prime? | Try divisors through the square root | O(√n) time, O(1) space |
| 13 | `5!` → 120 | Multiply from 2 through n | O(n) time, O(1) space |
| 14 | First 7 Fibonacci terms → `0,1,1,2,3,5,8` | Keep last two values | O(n) time and output |
| 15 | Merge `[1,3,5]` and `[2,4,6]` | Two pointers on sorted lists | O(n+m) time and output |
| 16 | Two Sum `[2,7,11]`, target 9 → indices `[0,1]` | Remember prior values and indices | O(n) expected time and space |

Limits are explicit in the code: the string exercises use ASCII rules; factorial and Fibonacci are capped to fit signed 64-bit integers; merging assumes sorted inputs; and `secondLargest()` returns `null` when no second **distinct** value exists. PHP arrays are hash tables, so the map-based operations have expected rather than absolute worst-case constant-time lookups. `solutions.php` also contains optional anagram, binary-search and bracket exercises beyond the video's 16 problems.

For a whiteboard answer, say what happens with an empty input, duplicates, negative numbers, invalid types, overflow and Unicode before claiming the algorithm is complete. The test runner covers these meaningful boundaries and fails with a named case if an answer changes unexpectedly.

References: [PHP array sorting stability (`uasort`)](https://www.php.net/manual/en/function.uasort.php), [email syntax validation (`filter_var`)](https://www.php.net/manual/en/function.filter-var.php).

Keep learning, keep coding.
