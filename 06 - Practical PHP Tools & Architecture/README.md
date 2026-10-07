# Part 6 — Practical PHP Tools & Architecture

This dependency-free PHP 8.2 mini app shows a **front controller → controller → service → repository → response** flow. The repository holds three fixed book records so no database setup or production data is involved. The route is a query parameter to avoid Apache rewrite configuration; a production router can provide clean paths.

## Run

Start XAMPP Apache and open:

`http://localhost/php-developer-fresher-interview-guide/06%20-%20Practical%20PHP%20Tools%20%26%20Architecture/public/index.php`

Or, from this folder, run:

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:8086 -t public
```

Then try these URLs in the browser or with `curl.exe`:

| Request | Expected result |
| --- | --- |
| `index.php` | HTML index, HTTP 200 |
| `index.php?route=/api/books` | Three JSON books, HTTP 200 |
| `index.php?route=/api/books&q=secure` | One matching JSON book, HTTP 200 |
| `index.php?route=/api/books/2` | Book 2, HTTP 200 |
| `index.php?route=/api/books/99` | JSON error, HTTP 404 |
| `index.php?route=/api/books&q[]=bad` | JSON validation error, HTTP 400 |
| `POST index.php?route=/api/books` | `Allow: GET`, HTTP 405 |

Run the focused service/controller checks with `C:\xampp\php\php.exe tests\run.php`. The database and operations examples are also independent CLI programs:

```powershell
C:\xampp\php\php.exe examples\database_patterns.php
C:\xampp\php\php.exe examples\cache_queue.php
```

The first needs the `pdo_sqlite` extension and uses in-memory SQLite for a transaction, one-query JOIN and keyset page. The second simulates TTL expiry and a queued job; it deliberately does **not** claim to be a durable shared cache or worker.

## The video's 30 questions

| # | Interview question | Answer / companion |
| ---: | --- | --- |
| 01 | Why Composer? | It resolves PHP package dependencies and provides autoloading. This example needs no packages. |
| 02 | `composer.json` vs `composer.lock`? | The former declares requirements; the latter records exact resolved versions for repeatable installs. |
| 03 | `install` vs `update`? | `install` uses the lockfile when present; `update` resolves newer allowed versions and updates it. |
| 04 | `^` vs `~` constraints? | `^2.3` allows compatible 2.x releases; `~2.3.1` stays below 2.4.0. Test the precise constraint in Composer before release. |
| 05 | Composer autoload and namespaces? | PSR-4 maps a namespace prefix to a directory; load `vendor/autoload.php` once. This no-dependency sample uses explicit `require` calls. |
| 06 | Config and secrets? | Supply environment-specific values outside committed source; validate on startup, and never print credentials. |
| 07 | Front controller? | All requests enter `public/index.php`, which dispatches to a route. See the mini app. |
| 08 | Router? | It matches method and route to a handler, with a 404/405 for misses. See `public/index.php`. |
| 09 | Controller, service, repository? | HTTP input/output, use-case rules, and data access respectively. See `src/`. |
| 10 | DI container? | It constructs and supplies dependencies. The mini app wires them by hand so the relationships are visible. |
| 11 | MVC? | Model handles data/domain, view renders output, controller coordinates a request. Layer boundaries vary by framework. |
| 12 | Middleware? | A request/response pipeline step can do auth, logging or rate limits around a handler. Order matters. |
| 13 | PSR-7? | A common request/response message interface; `with*()` methods return a new message rather than mutating the original. `Response` here is a smaller learning class, not PSR-7. |
| 14 | PSR-3? | A common logger interface and level names; log useful context without passwords or tokens. |
| 15 | CLI vs web PHP? | Different entry point, `$_SERVER` values, user, environment and sometimes a different `php.ini`. Run the CLI examples explicitly. |
| 16 | Unit, integration, end-to-end tests? | Isolated logic, collaboration with real dependencies, and full user path. `tests/run.php` checks the first kind; manual HTTP requests exercise routing. |
| 17 | Arrange-act-assert? | Prepare a service, invoke one behavior, then verify output/status. See the `tests/run.php` cases. |
| 18 | Fake, stub, mock? | Use a simple fake for working behavior, a stub for predefined responses, or a mock when interactions themselves matter. Avoid verifying incidental calls. |
| 19 | Migration? | A versioned database schema change, reviewed and deployed with a rollback plan. The SQLite script creates throwaway tables only. |
| 20 | Transaction? | Group related writes so they commit together or roll back. `examples/database_patterns.php` transfers cents between wallets. |
| 21 | N+1 queries? | Fetching one list then querying once per row causes 1 + N trips. The database example uses one JOIN. |
| 22 | Offset vs keyset pagination? | Offset skips N rows but can shift as data changes; keyset continues after a stable sort key. See the cursor query. |
| 23 | Cache invalidation? | A cached value can outlive a source update; choose keys, TTL and write invalidation deliberately. See `examples/cache_queue.php`. |
| 24 | Shared cache/session store? | Both need shared storage across servers, but separate namespaces, expiry policies, privacy and capacity. The in-memory cache is not shared. |
| 25 | Background queue? | Enqueue slow work so the request can finish; a worker handles it later with retries and idempotency. See the simulated queue. |
| 26 | HTTP methods and status codes? | GET reads; POST creates/actions; PUT replaces; PATCH changes part; DELETE removes. Match 2xx/4xx/5xx to outcomes. The mini app is GET-only. |
| 27 | API validation errors? | Return a stable JSON error and appropriate 4xx code, without stack traces. `BookController` returns 400 for invalid search. |
| 28 | Dev/test/prod config? | Keep the same code but change external endpoints, logging detail, credentials and limits per environment. |
| 29 | Environment parity? | Compare PHP versions, extensions, server configuration and services between XAMPP and deployment to prevent surprises. |
| 30 | Safe deployment checklist? | Back up and plan migrations, deploy compatible code/config, run health checks and smoke tests, watch errors, and have a rollback path. |

## Explain the design in an interview

- **Request lifecycle:** The web server chooses `public/index.php`; PHP reads the method and route; the controller validates HTTP input; the service handles a use case; the repository supplies data; `Response` sends status, content type and body.
- **Separation of concerns:** The controller does not search the data array itself. The service does not read `$_GET` or send headers. The repository can later be replaced by a PDO-backed implementation without moving HTTP handling into it.
- **HTTP and JSON:** A successful collection read returns 200 and JSON. Bad input returns 400, missing resource 404, and unsupported method 405. Every endpoint makes its content type explicit. A real API should define versioning and error formats consistently.
- **Validation and output:** A query parameter can be an array, even if a form normally sends a string. Check its type and size. `json_encode(..., JSON_THROW_ON_ERROR)` produces JSON; HTML output needs separate context-aware encoding.
- **Tools and dependencies:** Composer manages packages and normally provides PSR-4 autoloading. This example uses four explicit `require` statements to run without it. Use `composer.json` and a lockfile when a real project adopts dependencies; do not commit `vendor/` unless the project has a reason.
- **Configuration and logs:** Put environment-specific settings outside source control, validate them on startup, show generic errors publicly and log protected diagnostics. Do not commit `.env` files with secrets. The sample uses only fixed public data.
- **Testing:** A small service/controller check catches input, search and not-found behavior; HTTP smoke checks confirm routing and response codes. Neither replaces integration tests for a real database or web server configuration.

Common mistakes: returning `200` for errors; trusting `$_GET` to be a scalar; mixing SQL, HTML and HTTP in one function; using a global mutable configuration array everywhere; exposing exception traces to visitors; and installing a framework before understanding the request flow.

References: [Composer basic usage](https://getcomposer.org/doc/01-basic-usage.md), [version constraints](https://getcomposer.org/doc/articles/versions.md), [PSR-4](https://www.php-fig.org/psr/psr-4/), [PSR-7](https://www.php-fig.org/psr/psr-7/), [PSR-3](https://www.php-fig.org/psr/psr-3/), [PDO transactions](https://www.php.net/manual/en/pdo.transactions.php), [PHPUnit writing tests](https://docs.phpunit.de/en/11.5/writing-tests-for-phpunit.html).

Keep learning, keep coding.
