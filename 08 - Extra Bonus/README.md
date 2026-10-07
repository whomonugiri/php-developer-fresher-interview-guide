# Part 8 — Extra Bonus: Real-World PHP Troubleshooting

The final episode uses **24 practical scenarios**. The aim is a repeatable debugging method: reproduce, inspect protected evidence, isolate the cause, make the smallest fix, verify, and retain a rollback path. The CLI examples work with PHP 8.2 and do not use a production database or call an external service.

```powershell
C:\xampp\php\php.exe examples\input_json_dates.php
C:\xampp\php\php.exe examples\stream_and_paths.php
C:\xampp\php\php.exe examples\diagnostics.php
C:\xampp\php\php.exe examples\outbound_http.php
```

To try the web example, start XAMPP Apache and open `http://localhost/php-developer-fresher-interview-guide/08%20-%20Extra%20Bonus/web/prg.php`. Submit a nonempty name: the server returns HTTP 303 and the browser lands on a GET page. Refreshing the result does not resubmit the form. The sample performs no persistent write; a real state-changing form also needs authentication, authorization, CSRF protection, validation and duplicate-processing rules.

## The video's 24 scenarios

| # | Scenario | Investigation / fix |
| ---: | --- | --- |
| 01 | “Headers already sent” | Check for output, whitespace or a UTF-8 BOM before `header()`/`setcookie()`; send headers before HTML. See `web/prg.php`. |
| 02 | Undefined array key | Use `??` for an optional fallback, or validate a required key explicitly. Do not silence warnings globally. |
| 03 | Missing, null or empty? | `array_key_exists()` detects a present null; `isset()` does not. Compare an empty string separately. Run `input_json_dates.php`. |
| 04 | Production 500 error | Return a generic response to users, then inspect access/error logs with a request ID. Avoid displaying traces or secrets. |
| 05 | Dates differ between servers | Use explicit timezones; store instants in UTC and format for the user at the boundary. Run `input_json_dates.php`. |
| 06 | Garbled UTF-8 | Check the database connection charset, stored bytes, HTML/meta charset and HTTP `Content-Type`; avoid double encoding. The sample sends UTF-8. |
| 07 | JSON failure | Use `JSON_THROW_ON_ERROR`, catch `JsonException` at the boundary, and validate the decoded shape. Run `input_json_dates.php`. |
| 08 | Redirect behavior | Send a valid `Location` header before output and call `exit` immediately. `web/prg.php` uses HTTP 303 after POST. |
| 09 | Duplicate form submit on refresh | Apply Post/Redirect/Get to turn the result page into GET. It does not prevent double-clicks or concurrent duplicate writes; use idempotency where needed. |
| 10 | Large file read | Stream with `fgets()`/chunks instead of loading the entire file. See `stream_and_paths.php`; also check read errors and close handles. |
| 11 | `__DIR__` path | Build a path relative to the source file, independent of the shell's working directory. See `stream_and_paths.php`. |
| 12 | Missing required file | `require` fails fatally when a file is absent. Validate configuration and paths early, with a clear protected diagnostic. The stream sample checks its file. |
| 13 | Outbound HTTP timeout | Configure both connection and total timeouts, check status/errors and validate data. `outbound_http.php` defines a restricted pattern without making a request. |
| 14 | Unsafe retry | Retrying a non-idempotent POST can duplicate a charge or order. Use an idempotency key and server-side deduplication before retrying writes. |
| 15 | Stale cache | Check cache key, TTL and invalidation after source changes. Part 6's `examples/cache_queue.php` demonstrates TTL expiry. |
| 16 | OPcache after deploy | OPcache stores compiled PHP scripts. Use an intentional deployment/reload or invalidation strategy, then verify the running version. |
| 17 | Slow request | Measure database query count/time, outbound calls, lock waits and PHP execution; profile before changing code. Part 6's N+1 example shows one cause. |
| 18 | CLI vs web mismatch | Compare `PHP_VERSION`, SAPI, loaded `php.ini`, extensions, user and environment. Run `examples/diagnostics.php` in CLI, but do not expose it publicly. |
| 19 | Upload/long-request limits | Check `upload_max_filesize`, `post_max_size`, memory, execution time and web-server limits together. The diagnostics example prints local settings. |
| 20 | Safe production profiling | Keep traces and profiling output in protected tools/logs; show only generic errors to visitors, and avoid logging sensitive request data. |
| 21 | Request/correlation ID | Generate an opaque ID per request and attach it to protected logs across services. The diagnostics example creates one. |
| 22 | PHP-FPM worker exhaustion | Requests can queue when all workers are busy. Inspect pool metrics, slow logs and downstream bottlenecks before simply raising worker count. XAMPP Apache may use a different SAPI. |
| 23 | Deployment smoke test | Check a public route, authenticated/session flow, database health, static assets and logs against the deployed version. Roll back on a failing critical check. |
| 24 | Safe production-debug sequence | Reproduce safely, correlate evidence, isolate root cause, fix, test, deploy with monitoring and rollback readiness. Never experiment on live user data. |

### Troubleshooting notes

- Compare symptoms against the **same environment**: CLI and web may load different ini files or extensions.
- Preserve a minimal reproducible input and an expected result. Avoid putting real user data, tokens or passwords into tickets or logs.
- Differentiate a fix from a workaround. Raising limits or adding retries without finding the bottleneck can hide the problem or multiply writes.
- For HTTP calls, a timeout is a failure mode to handle, not proof the remote side did nothing; a retried write must be safe to repeat.

References: [PHP `header()`](https://www.php.net/manual/en/function.header.php), [JSON exceptions](https://www.php.net/manual/en/class.jsonexception.php), [cURL options](https://www.php.net/manual/en/function.curl-setopt.php), [PHP configuration](https://www.php.net/manual/en/ini.core.php).

Keep learning, keep coding.
