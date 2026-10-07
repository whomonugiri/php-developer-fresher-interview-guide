# Part 4 — Sessions, Cookies & Security (30 questions)

Companion to the **final 16:58 Dev Ninja Part 4 whiteboard video**. Each numbered row follows the video order. The video shows short excerpts; this folder adds complete local examples, expected results, and important limits. Start with the [browser demo](demo/index.php), then try the three [CLI examples](examples).

## Run locally with XAMPP

1. Use PHP 8.1+ with the `fileinfo`, `PDO`, and `pdo_sqlite` extensions. XAMPP PHP 8.2 is suitable. Start Apache. No MySQL database is needed.
2. Place this repository under `C:\xampp\htdocs\php-developer-fresher-interview-guide` (as it is in this checkout). Open `http://localhost/php-developer-fresher-interview-guide/04%20-%20Sessions%2CCookies%20%26%20Security/demo/index.php`.
3. The **local sample account** is `learner@example.test` / `DemoPass!123`. Its fixed hash is included in the source solely for practice. Never use this account, password, or this no-database login in a deployed app.
4. In a terminal, from this Part 4 folder, run `C:\xampp\php\php.exe examples\password_and_sql.php`, `C:\xampp\php\php.exe examples\one_time_tokens.php`, and `C:\xampp\php\php.exe examples\cookie_integrity.php`.

The browser demo uses HTTP on localhost, so `Secure` cookies and HSTS are enabled **only when the connection is HTTPS**. Real logins must run over HTTPS. The upload demo stores small files in `sys_get_temp_dir()/dev-ninja-guide-private-uploads`, outside the document root; remove that practice directory when done. Do not move it into `htdocs`. Use a fresh browser profile when testing the sample account.

### What to observe

- `login.php` rejects a wrong password, then a correct password redirects with HTTP 303 to the protected profile. The session ID is rotated after successful verification.
- `profile.php` redirects a logged-out visitor to login. Its logout form sends a POST with a CSRF token. A GET to `logout.php` returns 405; a POST without the token returns 403. After logout, the old session no longer opens the profile.
- `cookie.php` sets `demo_theme` to `dark` or `light`, then redirects. The selected value appears on the **next** request. Delete uses a past expiry with the same path and flags. An edited value such as `admin` is treated as `none`.
- `upload.php` requires login and a CSRF token, checks size and detected MIME, renames the file randomly, and keeps it outside the web root. `download.php` checks that the requested ID belongs to this server-side session; another ID returns 404. Files are offered as attachments.
- `password_and_sql.php` accepts the correct password, rejects the wrong one, and returns **0 rows** for a SQL-injection-shaped email. `one_time_tokens.php` accepts each token once, then rejects reuse. `cookie_integrity.php` rejects an altered signed value.

## The 30 interview questions

| # | Video question | Short interview answer and example |
| ---: | --- | --- |
| 01 | Session vs cookie? | A cookie is stored by the browser and sent with matching requests. PHP session data normally lives on the server; a browser cookie carries its session ID. See `demo/bootstrap.php` and `demo/cookie.php`. |
| 02 | What does `session_start()` do? | It resumes or creates a session from the request's valid ID and makes `$_SESSION` available. Call it before output, after setting session options. See `demo/bootstrap.php`. |
| 03 | Store, read, remove session data? | Assign `$_SESSION['city'] = 'Pune'`, read with `$_SESSION['city'] ?? 'Unknown'`, and `unset($_SESSION['city'])` to remove one key. `demo/login.php` writes auth data; `demo/logout.php` clears all keys. |
| 04 | Create and read a cookie? | `setcookie()` sends a response header. `$_COOKIE` describes cookies on the **current request**, so read the new value after redirecting/reloading. See `demo/cookie.php`. |
| 05 | Cookie expiry and deletion? | A future `expires` retains a persistent cookie. Deleting requires a past expiry and matching name, path and domain. It removes the browser copy, not server data. See `demo/cookie.php`. |
| 06 | `Secure`, `HttpOnly`, `SameSite`? | `Secure` limits sending to HTTPS; `HttpOnly` blocks JavaScript reads; `SameSite` limits some cross-site sending. None replaces CSRF defenses or HTTPS. See `demo/bootstrap.php`. |
| 07 | Regenerate ID after login? | After verifying credentials, call `session_regenerate_id(true)` before setting authenticated data to reduce session fixation. See `demo/login.php`. At scale, plan for simultaneous requests and old-ID lifecycle. |
| 08 | Does closing the browser end login? | No guarantee: browsers can restore session cookies, and server data can survive. Enforce idle and absolute time limits server-side. `demo/bootstrap.php` uses 15-minute idle and 8-hour maximum lifetimes. |
| 09 | Correct logout? | Require a POST and valid CSRF token, empty `$_SESSION`, expire the session cookie using its original scope, destroy the server session, then redirect. See `demo/logout.php`. |
| 10 | Store passwords? | Store `password_hash($password, PASSWORD_DEFAULT)` in a database, never plaintext or a fast general hash. See `examples/password_and_sql.php`. |
| 11 | Verify password? | Load the stored hash for that account and call `password_verify($candidate, $hash)`. Rehash after successful login if `password_needs_rehash()` says yes. See the CLI example. |
| 12 | Prepared statements and SQL injection? | Keep SQL structure fixed and bind untrusted **values**. Parameters cannot bind table or column names; choose dynamic identifiers from an allowlist. See `examples/password_and_sql.php`. |
| 13 | Production PHP errors? | Show a generic failure to users; keep detailed diagnostics in protected logs. Set `display_errors=Off` and `log_errors=On` in production configuration. Never log passwords or tokens. |
| 14 | What is XSS? | Untrusted text can become executable HTML/JavaScript. Encode for the *output context*: for HTML text/attributes use `htmlspecialchars($value, ENT_QUOTES \| ENT_SUBSTITUTE, 'UTF-8')`. See `demo_escape()` in `demo/bootstrap.php`. Do not reuse HTML encoding for JavaScript or URLs. |
| 15 | What is CSRF? | Another site can cause the victim's browser to send credential-bearing requests. Use unpredictable session-bound tokens on state-changing forms, plus sensible cookie flags. See `demo/cookie.php`. |
| 16 | Validate a CSRF token? | Require the intended HTTP method; confirm both tokens are strings; compare with `hash_equals()` *before* changing state. Reject missing/invalid tokens. See `demo_require_post_and_csrf()`. |
| 17 | Validation vs output encoding? | Validation checks whether input fits a rule; output encoding makes accepted data safe in its destination. An email format check does not prove ownership; SQL binding is separate. |
| 18 | Authentication vs authorization? | Authentication establishes identity. Authorization checks whether that identity may perform **this** action on **this** resource, on every request. See `demo_require_auth()` and `demo/download.php`. |
| 19 | Safe uploads? | Limit size and MIME using server-side checks, generate a random name, store outside the web root, and require authorization to retrieve. Do not trust the original filename, extension or browser MIME claim. See `demo/upload.php`. |
| 20 | Repeated login attacks? | Rate-limit by account and source using a shared, persistent store; monitor failures and use MFA where appropriate. Return generic login errors. A PHP-session counter alone is easy to evade; this local demo intentionally does **not** claim to implement rate limiting. |
| 21 | Session fixation vs hijacking? | Fixation plants a known session ID before login; hijacking steals a valid one. Strict mode and rotation help fixation; HTTPS, secure cookie flags, XSS defenses and expiry reduce theft. |
| 22 | Why can sessions block parallel requests? | PHP's common file session handler locks a session while a request has it open. Finish writes and call `session_write_close()` before slow independent work; further `$_SESSION` writes will not persist. See `demo/download.php`. |
| 23 | Sessions on multiple PHP servers? | Any server receiving the session ID must reach the same session data. Use a shared, appropriately locked session store and consistent cookie, serialization and key settings; do not depend solely on one machine's local files. |
| 24 | Trust a browser cookie? | No. A visitor can edit a cookie, even if JavaScript cannot read an `HttpOnly` one. `demo/cookie.php` accepts only harmless `dark`/`light` preferences; roles and file access are checked server-side. |
| 25 | Signing vs encrypting a cookie? | A signature/HMAC detects changes but leaves data visible. Authenticated encryption also hides contents. Protect and rotate keys; neither grants authorization. Run `examples/cookie_integrity.php` to see tampering rejected. |
| 26 | Remember-me token? | Put a cryptographically random opaque token in a `Secure`, `HttpOnly`, `SameSite` cookie. Store only its hash with user, expiry and revocation state server-side; rotate after use. `examples/one_time_tokens.php` models token issuance/consumption, not a complete remember-me service. |
| 27 | Password reset link? | Reply generically to reset requests, even for unknown accounts. Send a short-lived, random, single-use token over a trusted channel; store its hash; invalidate it and relevant sessions after password change. See the token example. |
| 28 | Email verification link? | A short-lived, single-use link demonstrates access to that mailbox **at that time**. Check purpose, expiry and token, then mark the address verified; it does not authenticate the user. See the token example. |
| 29 | Useful HTTP security headers? | `Content-Security-Policy` constrains content, `X-Content-Type-Options: nosniff` blocks sniffing, framing policy limits embedding, and HSTS enforces HTTPS after a secure visit. Test CSP/HSTS for your site before rollout. See `demo/bootstrap.php`. |
| 30 | Prevent another user's file download? | Resolve file metadata from an opaque ID, check current user's permission on **that** file, then stream from private storage. Hidden URLs alone are not access control. See `demo/download.php`. |

### A few common mistakes to call out in an interview

- **POST is not a CSRF defense.** A malicious site can submit a form. Require a token or another suitable CSRF defense for cookie-authenticated state changes.
- **Client input is never an authorization source.** A signed cookie resists tampering, but the server must still decide current permissions, including revocations.
- **Prepared placeholders bind data, not SQL syntax.** For a sortable column, map user choices such as `name` to fixed SQL identifiers; never interpolate an unchecked string.
- **A MIME check is only one upload layer.** Also control size, storage, file execution, authorization and lifecycle. For higher-risk file types, consider content scanning or transformation.
- **`SameSite=Lax` is helpful but incomplete.** Keep explicit CSRF tokens for the state-changing forms in this demo.
- **Demo account and token storage are teaching aids.** A real app needs persistent users/tokens, per-user permission data, durable rate limiting, monitoring, account recovery workflow and reviewed production settings.

## Further reading

- [PHP sessions](https://www.php.net/manual/en/book.session.php), [password hashing](https://www.php.net/manual/en/book.password.php), [PDO prepared statements](https://www.php.net/manual/en/pdo.prepared-statements.php)
- [OWASP Session Management](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html), [Forgot Password](https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html), [Authorization](https://cheatsheetseries.owasp.org/cheatsheets/Authorization_Cheat_Sheet.html), [HTTP Security Response Headers](https://cheatsheetseries.owasp.org/cheatsheets/HTTP_Headers_Cheat_Sheet.html)

Keep learning, keep coding.
