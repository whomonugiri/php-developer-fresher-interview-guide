# PHP Fundamentals: interview answers you can execute

This section keeps all **12 original topics and filenames**, with clearer interview answers, independently runnable examples, and boundary/error tests. The compatibility baseline is **PHP 8.1+**. Use a currently supported PHP release for real applications.

No Composer packages, database, web server, network service, or credentials are needed. The examples use the standard PHP CLI. All functions live in `PhpSeries\Fundamentals` so the test suite can load them together without name collisions.

## Run and study

Run these commands from the repository root. Quote paths because lesson filenames contain spaces and shell metacharacters.

```sh
php --version
php '01 - PHP Fundamentals/01 - What is PHP.php'
php '01 - PHP Fundamentals/06 - Explain if,elseif, switch and match.php'
php '01 - PHP Fundamentals/tests/run.php'
```

On Windows/XAMPP, run from the repository root in PowerShell:

```powershell
C:\xampp\php\php.exe '01 - PHP Fundamentals/01 - What is PHP.php'
C:\xampp\php\php.exe '01 - PHP Fundamentals/tests/run.php'
```

To syntax-check the section on a Unix-like shell:

```sh
find '01 - PHP Fundamentals' -name '*.php' -print0 | xargs -0 -n 1 php -l
```

Each numbered file can be executed directly with `php 'path/to/file.php'`. Its comments state what to expect; most examples print readable JSON. Importing a lesson with `require_once` defines its functions without printing its demonstration. The direct-execution guard at the end is infrastructure for that behavior, not a PHP web-routing pattern.

Suggested practice: answer the question aloud, predict the example's output, run it, and then change one input. Use the follow-up questions below to explain *why* the result changes.

## Coverage map

| Original topic | Retained runnable file | Added checks and follow-up |
| --- | --- | --- |
| 01. What is PHP? | [01 - What is PHP.php](./01%20-%20What%20is%20PHP.php) | CLI/server distinction; HTML output escaping; empty input |
| 02. echo vs print | [02 - echo vs print.php](./02%20-%20echo%20vs%20print.php) | Output capture; multiple echo expressions; print's integer result |
| 03. Variables and common data types | [03 - Explain Variables & Common data types.php](./03%20-%20Explain%20Variables%20%26%20Common%20data%20types.php) | Reassignment; case sensitivity; scalar/compound/null/resource examples |
| 04. == vs === | [04 - What is the difference between == and ===.php](./04%20-%20What%20is%20the%20difference%20between%20%3D%3D%20and%20%3D%3D%3D.php) | Numeric strings; PHP 8 non-numeric comparison; false vs offset zero |
| 05. Constants | [05 - What are constants.php](./05%20-%20What%20are%20constants.php) | const vs define; namespaces; arrays; repeated calls; no sample secrets |
| 06. if, elseif, switch, match | [06 - Explain if,elseif, switch and match.php](./06%20-%20Explain%20if%2Celseif%2C%20switch%20and%20match.php) | Range boundaries; loose vs strict matching; grouped arms; unmatched error |
| 07. Functions, parameters, returns, type hints | [07 - What is function, parameters , return values and type hints.php](./07%20-%20What%20is%20function%2C%20parameters%20%2C%20return%20values%20and%20type%20hints.php) | Defaults; named/variadic arguments; nullable input; strict and weak callers |
| 08. Local, global, static scope | [08 - Local,Global & Static Variables & Scopes.php](./08%20-%20Local%2CGlobal%20%26%20Static%20Variables%20%26%20Scopes.php) | Explicit inputs; global import; persistent static local; independent closures |
| 09. Single vs double quotes | [09 - Single Quotes vs Double Quotes.php](./09%20-%20Single%20Quotes%20vs%20Double%20Quotes.php) | Interpolation; escapes; literal dollar sign; concatenation |
| 10. $ vs $$ | [10 - $$ vs $.php](./10%20-%20%24%24%20vs%20%24.php) | Variable variables; explicit-array alternative; key/type rejection |
| 11. for, while, do...while, foreach | [11 - for,while,do while, foreach loop.php](./11%20-%20for%2Cwhile%2Cdo%20while%2C%20foreach%20loop.php) | Bounds; loop termination; key/value iteration; references; break/continue |
| 12. Ternary operator | [12 - what is ternary operator.php](./12%20-%20what%20is%20ternary%20operator.php) | Full/short ternary vs ??; falsy values; missing keys; explicit validation |

## Interview questions and model answers

### 01. What is PHP, and what happens during a web request?

**Answer:** PHP is a general-purpose language widely used for server-side web development. A typical web request reaches a web server, is routed to a PHP runtime such as PHP-FPM, runs application code, and returns a response body and headers. The body might be HTML or JSON. PHP also runs command-line scripts, workers, and scheduled jobs.

**Follow-up: Does the browser execute the PHP source?** Ordinarily it receives only the generated response. A misconfigured server can expose source, so this depends on deployment configuration. HTML is markup, CSS describes presentation, and JavaScript can execute in either browser or server environments.

**Practice:** `greetingHtml('Ada & Lin')` returns `<h1>Hello, Ada &amp; Lin</h1>`. Try an HTML tag as input. Escaping at an HTML text output boundary helps prevent that tag becoming markup. This does not make the value safe for every other output context.

### 02. How do echo and print differ?

**Answer:** Both are language constructs. `echo` has no return value and can emit comma-separated expressions. `print` accepts one expression and returns integer `1`, so its result can be assigned. Neither automatically adds whitespace or a newline.

**Follow-up: Should a team choose between them for performance?** Usually readability and consistency matter far more. Do not describe either construct as an ordinary function or rely on tiny benchmark differences.

**Predict:** The demo captures `Hello, PHP` and `Printed` on separate lines; the separate `print_return` value is `1`. Output buffering is used only to make the behavior easy to test. [Manual: echo](https://www.php.net/manual/en/function.echo.php).

### 03. What does dynamically typed mean? Which values can variables hold?

**Answer:** A variable's runtime value determines its type; reassignment may change that type. Common values include `int`, `float`, `bool`, `string`, `array`, objects, `null`, and resources such as open streams. Type declarations constrain function parameters, returns, and typed properties; they do not make every local variable statically typed.

**Follow-up: Are $name and $NAME the same?** No. Use descriptive, case-consistent names. A portable naming convention is `$` followed by a letter or underscore, then letters, digits, or underscores.

**Predict:** Reassigning `'42'` to `42` changes `get_debug_type()` from `string` to `int`. `null` is a value; it is different from an undeclared variable. The stream example closes its handle with `finally`.

### 04. Why use === instead of ==?

**Answer:** `==` permits type conversion; `===` compares type and value. Prefer explicit parsing followed by strict comparison when external data has an expected type.

**Predict:** `10 == '10'` is true; `10 === '10'` is false. In PHP 8, `0 == 'text'` is false, while `0 == '0'` remains true.

**Follow-up: Why is if (strpos(...)) a bug?** A successful match can have offset `0`, which is falsy. Compare its result with `!== false`. `strict_types=1` does not modify these comparison rules. [Manual: comparisons](https://www.php.net/manual/en/language.operators.comparison.php).

### 05. What is a constant? When do you use const versus define?

**Answer:** A constant is a named value that cannot be reassigned during execution. Access does not use `$`, and names are case-sensitive. Namespace-level `const` uses a constant expression and is declared outside functions or conditionals. `define()` runs at runtime and may be called conditionally. Both can represent arrays.

**Follow-up: Are all constants simply global variables without a dollar sign?** No. Constants have their own resolution rules. Namespaces qualify names, and class constants belong to classes and may have visibility. A string passed to `define()` is the name it defines; this example explicitly constructs its namespace-qualified name.

**Practice:** Call `constantExamples()` twice. The conditional `defined()` check avoids redefining its runtime constant. Public demo settings are used instead of credential-shaped values. [Manual: constants](https://www.php.net/manual/en/language.constants.php).

### 06. When would you use if, switch, or match?

**Answer:** Use `if`/`elseif` for arbitrary conditions and ranges. `switch` compares cases loosely and permits fall-through; use `break` or an appropriate `return` when fall-through is not intended. `match` is a PHP 8 expression that selects a value by strict identity and has no fall-through.

**Predict:** `switchDay('1')` returns `Monday`, whereas `matchDay('1')` returns `Other`. `matchDay(1)` returns `Monday`. Grouped match arms can share one result.

**Follow-up: What happens without a matching arm or default?** `UnhandledMatchError` is thrown. The tests deliberately pass `2` to `binaryFlag()` and require that error. [Manual: match](https://www.php.net/manual/en/control-structures.match.php).

### 07. How do parameters, arguments, return types, and strict typing work?

**Answer:** Parameters declare inputs; arguments are supplied by the caller. `return` sends a result back. Returning a string does not print it. Optional parameters have defaults and should follow required parameters. Variadics collect trailing arguments; named arguments refer to declared parameter names, so renaming public parameters can affect callers.

**Follow-up: Does strict_types=1 in a function's file guarantee strict scalar arguments from every caller?** No. For these direct calls, the calling file selects scalar argument strictness. The strict test caller rejects `'2'` for `int`; the deliberately weak fixture accepts it as `2`. An `int` can still satisfy a `float` declaration. Return checks follow the declaration's file.

**Follow-up: Does ?string mean optional?** It means string or null. A default makes omission legal. `optionalGreeting(?string $name = null)` has both properties. Types still do not validate a business rule such as a positive quantity. These arithmetic examples use small integers; overflow is a separate boundary to consider. [Manual: type declarations](https://www.php.net/manual/en/language.types.declarations.php).

### 08. Explain local, global, and static variables.

**Answer:** A local binding belongs to a function call. `global` imports a binding from global scope; `$GLOBALS` provides explicit access to those bindings. Passing an input as a parameter normally makes dependencies clearer. A static local retains its value between calls during the current execution.

**Follow-up: Can static locals replace sessions or a database?** No. They are not durable storage or shared state across arbitrary workers. Traditional requests and long-running workers have different execution lifetimes. Do not assume every job gets fresh static state.

**Predict:** A static counter increments on each call. Two separately created closures have independent counters. Values may survive an ordinary local binding when they are returned or captured elsewhere; scope alone does not guarantee immediate memory reclamation. [Manual: variable scope](https://www.php.net/manual/en/language.variables.scope.php).

### 09. How do single-quoted and double-quoted strings differ?

**Answer:** Double-quoted strings interpolate variables and interpret escapes such as `\n`. Single quotes preserve `$name` and `\n` literally, with special handling for escaped single quotes and backslashes. Use `{$name}` when interpolation boundaries need to be clear, or concatenate with `.`.

**Predict:** `'Hello, $name\n'` contains a dollar-name and backslash-n; `"Hello, {$name}\n"` substitutes the name and ends in a newline. The JSON output makes the distinction visible.

**Follow-up: Does choosing a quote style prevent SQL injection or XSS?** No. SQL parameters and context-appropriate output escaping solve different problems. [Manual: strings](https://www.php.net/manual/en/language.types.string.php).

### 10. What is a variable variable, and why prefer an array?

**Answer:** If `$key` is `'planet'`, assigning through `$$key` writes `$planet`. The language feature exists, but dynamically chosen variable names obscure dependencies and can accidentally overwrite bindings. Prefer `$values[$key]` to group dynamic data explicitly.

**Follow-up: Is replacing $$ with an array sufficient input validation?** No. The `allowedSetting()` example also restricts keys and checks value types. Its null/missing value behavior is explicitly to use the default. Unknown keys or non-string values throw exceptions. The example uses no `eval()` and does not create variables from request input.

### 11. Compare for, while, do...while, and foreach.

**Answer:** `for` conveniently groups initialization, a condition, and an update; `while` tests before each iteration; `do...while` tests after its body and therefore runs at least once. `foreach` iterates arrays or iterable objects without requiring a manual numeric index. Arrays may have string keys or noncontiguous integer keys.

**Follow-up: What do break and continue do?** `break` exits the loop; `continue` skips to the next iteration. The sample skips even numbers and stops at `5`, yielding `[1, 3]`.

**Follow-up: What is the reference-loop trap?** After `foreach ($items as &$value)`, `$value` remains an alias to the last element. `unset($value)` detaches that alias before the variable is reused. The test verifies that assigning `999` afterward does not corrupt the final element. [Manual: foreach](https://www.php.net/manual/en/control-structures.foreach.php).

### 12. How do full ternary, short ternary, and null coalescing differ?

**Answer:** `$condition ? $yes : $no` selects one branch. `$value ?: $fallback` falls back for any falsy value. `$value ?? $fallback` falls back for null or a missing variable/key, preserving `0`, `false`, `''`, `'0'`, and empty arrays.

**Follow-up: Can ?? validate a request parameter?** No. `pageSize()` defaults a missing/null size, then checks integer type and range. HTTP input commonly needs explicit parsing before using such an API.

**Predict:** With `0`, short ternary returns `fallback`; coalescing returns integer `0`. Parenthesize nested full ternaries in PHP 8, or use ordinary branches for clarity. [Manual: ternary and coalescing](https://www.php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary).

## Tests and verification

[tests/run.php](./tests/run.php) is a dependency-free CLI runner. It checks every original topic, uses strict comparisons, exercises expected exceptions, converts unexpected reported warnings to failures, and exits nonzero when a test fails. It does not rely on PHP's configurable `assert()` setting.

The intentionally weak [calling fixture](./tests/fixtures/weak_caller.php) demonstrates the caller-side strictness rule; it is not the recommended style for the rest of the repository. Tests do not contact external systems. The only stream is an in-memory stream that is closed immediately.

Verified on 2026-10-08 with PHP 8.4.24: all section files passed syntax lint, all 54 test cases passed, and all 12 standalone lesson examples executed without warnings. The PHP 8.1 compatibility baseline has not been exercised in this verification run. Use the commands above to repeat the checks in your own environment.

## A short interview drill

1. Explain what reaches the browser and escape a string for an HTML text node.
2. Predict the type and value of `print`'s result.
3. Contrast dynamic typing with declared parameter types.
4. Explain why a found offset of zero must be compared strictly.
5. Choose `const` or `define()` for a runtime conditional declaration.
6. Compare the treatment of `'1'` in `switch` and `match`.
7. Explain why strictness differs between the two calling files.
8. Predict two independent closure counters without running them.
9. Explain a literal `\n` versus an actual newline.
10. Replace a variable variable with an explicit array and key validation.
11. Repair a dangling reference after `foreach`.
12. Preserve a legitimate zero while supplying a default for missing data.
