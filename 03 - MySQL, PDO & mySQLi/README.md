# Part 3 — MySQL, PDO and MySQLi

A readable replacement for slide-only revision, with the original **20 questions and follow-ups** mapped below. The PNG slides remain as a visual reference. Read the answer, predict the example, run it, then explain the limitation in your own words.

## Run safely

- PHP **8.1+**; PHP 8.2 recommended across this series. No Composer dependency.
- Pure-function tests need no database: `php tests/run.php`.
- Database examples need a local **MySQL 8+ or MariaDB 10.4+** server with InnoDB, plus PHP `pdo_mysql` and `mysqli` extensions. Check `php -m`.
- Use a fresh disposable database named **php_interview_lab** only. These examples are CLI-only and reject another database name.
- In XAMPP start MySQL, open phpMyAdmin and create `php_interview_lab` with `utf8mb4_unicode_ci`. Select that database and import `sql/schema.sql` once. The schema intentionally refuses to overwrite existing tables. Do not import it into a real project.
- Use a local dedicated account with SELECT, INSERT, UPDATE and DELETE on this lab, created through your database administration tool. Do not use a production account or commit passwords.
- MySQL clients can alternatively import with `mysql -u YOUR_SETUP_USER -p php_interview_lab < sql/schema.sql` (shell redirection in bash/cmd). Use a setup account with CREATE privileges only for setup; no credentials are stored in this repository.

From this folder, set connection settings in the current shell, then run:

```bash
export DB_HOST=127.0.0.1 DB_PORT=3306 DB_NAME=php_interview_lab DB_USER=php_learner
# Set DB_PASSWORD privately in your shell if required. Never paste real secrets into source.
php tests/run.php
php examples/pdo_crud.php
php examples/mysqli_select.php
php examples/pagination.php
php examples/search_and_fetch.php
php examples/transaction.php
RUN_DB_TESTS=1 php tests/database.php
```

PowerShell/XAMPP equivalents:

```powershell
$env:DB_HOST='127.0.0.1'; $env:DB_NAME='php_interview_lab'; $env:DB_USER='php_learner'
# Set $env:DB_PASSWORD privately if required.
C:\xampp\php\php.exe tests\run.php
C:\xampp\php\php.exe examples\pdo_crud.php
$env:RUN_DB_TESTS='1'
C:\xampp\php\php.exe tests\database.php
Remove-Item Env:RUN_DB_TESTS
```

Replace `php` with `C:\xampp\php\php.exe` for the other commands. Runtime data is deliberately separate from code. The write demonstrations and integration fixtures roll back, but auto-increment IDs can still advance. Never run a lab against production.

## Questions and original coverage

| # | Interview answer and important follow-up | Try it | Original slide(s) |
| --- | --- | --- | --- |
| 1 | **MySQL vs SQL vs phpMyAdmin:** MySQL is a relational database server; SQL is the language used to query it; phpMyAdmin is an administration UI. A table contains rows with named columns. PHP can connect without phpMyAdmin. | `sql/schema.sql` | 2 |
| 2 | **Choose types by meaning:** integer for counts/IDs, DECIMAL for exact decimal amounts, VARCHAR for bounded text and phone numbers, DATE for a calendar date. A phone number is not arithmetic and can have leading zeroes. FLOAT/DOUBLE are approximate. Choose nullability, range and charset deliberately. | Compare the three tables in `schema.sql` | 3 |
| 3 | **Keys:** PRIMARY KEY identifies a row and cannot be NULL. UNIQUE prevents duplicate non-NULL values; MySQL permits multiple NULLs in a nullable unique column. FOREIGN KEY enforces valid references, with explicitly chosen delete/update behavior. AUTO_INCREMENT creates IDs, not gapless invoice numbering. | Unique email, two foreign keys and composite enrollment key | 4–5 |
| 4 | **Normalization:** store each fact in one appropriate place to avoid update/insert/delete anomalies. 1NF avoids repeating groups; 2NF removes partial dependencies on a composite key; 3NF removes inappropriate transitive dependencies between non-key attributes. Students and courses are many-to-many, so `enrollments` links them instead of storing comma-separated course IDs. | Inspect `enrollments`; its composite key prevents duplicate enrollment | 6–7 |
| 5 | **CRUD:** Create records with INSERT, read with SELECT, change with UPDATE, remove with DELETE. CRUD's create is normally INSERT, not CREATE TABLE. A missing WHERE can change every row. Validate inputs and enforce authorization before writes in a real web app. | `examples/pdo_crud.php` | 8 |
| 6 | **WHERE vs HAVING:** WHERE filters input rows; GROUP BY forms groups; HAVING filters aggregates. COUNT(*) counts rows, COUNT(column) counts non-NULL values, including empty strings. Use `IS NULL`, not `= NULL`. | `sql/practice.sql`: total 3 students, 2 known cities | 9–10 |
| 7 | **INNER vs LEFT JOIN:** INNER retains matches; LEFT retains all left rows and fills unmatched right columns with NULL. To find unenrolled students, use LEFT JOIN plus a NULL test on a non-nullable right key, or NOT EXISTS. Filtering the right table in WHERE can unintentionally remove unmatched rows. | Two equivalent anti-joins in `practice.sql` | 11–12 |
| 8 | **DELETE vs TRUNCATE vs DROP:** DELETE removes selected rows and is transactional for InnoDB. TRUNCATE removes all rows, resets numbering, and is DDL; DROP removes the table definition and data. MySQL's implicit commits mean TRUNCATE/DROP are not undone by ordinary transaction rollback. Foreign keys may prohibit truncation. These destructive commands are not run by the examples. | Safe ID-targeted DELETE in `pdo_crud.php` | 13 |
| 9 | **Indexes:** speed suitable lookups, joins and ordering at the cost of storage and writes. Do not index every column. Use EXPLAIN, real row counts, selectivity and the leftmost-prefix rule for composite indexes. On three rows a scan may be cheaper than using an index. | `EXPLAIN` in `practice.sql` | 14 |
| 10 | **PDO vs MySQLi:** PDO provides a consistent interface across supported drivers; MySQLi targets MySQL. Both support prepared statements and transactions. PDO does not make every dialect's SQL portable. Pick one consistently for a project. | Compare the PDO and MySQLi examples | 15 |
| 11 | **PDO connection:** use a DSN containing host, port, database and charset; use exception error mode and explicit fetch mode. Keep credentials outside source. `config.php` disables emulated prepares. Log internal failures privately and return a generic message in production. | `config.php` | 16 |
| 12 | **SQL injection:** attacker input becomes SQL syntax when concatenated into a query. Bind complete data values in prepared statements, without adding quotes around placeholders. Identifiers, keywords and an entire IN list cannot be bound as one parameter; use allowlists for structure and one placeholder per list value. Binding is not authorization, validation or output escaping. | Injection-string assertion in `tests/database.php` | 17 |
| 13 | **Fetch and counting:** fetch() consumes the next row or returns false; fetchAll() loads remaining rows into an array and may use substantial memory. Use COUNT(*) plus fetchColumn() for a total. PDO rowCount() on SELECT is driver-dependent and must not be used as a portable result count. | `examples/search_and_fetch.php` | 18–19 |
| 14 | **INSERT and generated ID:** validate, execute a prepared INSERT, then read lastInsertId() on the same connection immediately. Do not use MAX(id). An availability pre-check does not prevent concurrent duplicate inserts: a UNIQUE constraint is the final guard. Handle the specific duplicate-key error, not every failure as a duplicate. | `pdo_crud.php`; duplicate-email integration check | 20–21 |
| 15 | **bindParam vs bindValue:** bindParam binds a variable by reference and reads its value at execute time. bindValue binds the supplied value then. Execute-array values are convenient; explicitly bind integer LIMIT/OFFSET parameters. | Final two outputs in `search_and_fetch.php` | 22 |
| 16 | **Safe updates and rowCount:** bind values and use an intentional WHERE. With the default MySQL changed-row behavior, zero can mean no matching row or the value was already the same; it does not itself mean an error. CLIENT_FOUND_ROWS changes this interpretation. Exceptions report query errors. | Changed rows 1, same-value update 0 in `pdo_crud.php` | 23 |
| 17 | **MySQLi prepared statements:** prepare, bind_param, execute, bind_result/fetch, close. Set utf8mb4 and explicit strict error reporting. Bind variables by reference using type letters. get_result needs mysqlnd; this example uses bind_result instead. | `examples/mysqli_select.php` | 24 |
| 18 | **Pagination:** validate bounds, calculate `(page - 1) * size`, bind integer LIMIT/OFFSET and use deterministic ORDER BY with a unique tie-breaker. Large offsets are expensive; consider keyset pagination. Concurrent inserts can still shift offset-based pages. | `queries.php`, `examples/pagination.php` | 25 |
| 19 | **Transactions and ACID:** atomicity means all-or-nothing; consistency means constraints/invariants remain valid; isolation controls concurrent interaction; durability means committed changes survive according to the engine's guarantees. Begin, perform related writes, commit only on success; roll back on failure. Transactions alone do not fix race-prone logic: the conditional seat UPDATE plus row-count check prevents overselling, and insertion shares the same transaction. Rollback cannot unsend an email. | `reserveSeat()`, `examples/transaction.php`, failure tests | 26–29 |
| 20 | **Search and dynamic sorting:** bind the LIKE pattern, choose ORDER BY only from a fixed map. `%` and `_` still act as wildcards after binding; escape them separately if the search should be literal, using the same ESCAPE character in SQL. Collation governs case/accent behavior. | `literalLike()`, `studentOrder()`, `search_and_fetch.php` | 30–31 |

Slides 1 and 33 are the introduction/next-part cards. Slide 32's revision traps are incorporated in questions 12–14 and 19–20. Original image footers say “/35”, but this checkout contains 33 PNGs; the mapping is to the actual filenames.

## Expected results on a fresh seed

| Command | Expected observation |
| --- | --- |
| `php tests/run.php` | 13 configuration/query checks pass, no database connection |
| `php examples/pdo_crud.php` | Variable inserted ID; Demo Learner in Delhi; changed 1, unchanged 0, deleted 1; rollback notice |
| `php examples/mysqli_select.php` | `Asha <asha@example.test>` |
| `php examples/pagination.php` | First two students sorted by name: Asha then Kabir |
| `php examples/search_and_fetch.php` | Asha, Kabir, Meera; total 3; remaining 0; bindParam Kabir, bindValue Asha |
| `php examples/transaction.php` | Last-seat reservation and rollback notices; original seat count remains 1 |
| `RUN_DB_TESTS=1 php tests/database.php` | Duplicate, injection, pagination, seat and rollback checks pass; fixtures rolled back |

The database suite checks single-connection behavior and failure rollback; it does **not** simulate truly concurrent clients. To explore concurrency, use two independent sessions in a disposable database, leave the first seat UPDATE uncommitted, run the same update in the second session, then commit/rollback the first and inspect the second's row count. Configure a short lock timeout and roll back both sessions afterward. Never claim a concurrency stress test from the unit tests alone.

## Verification status

Verified on 2026-10-08 with PHP 8.4.24: all section PHP files passed syntax lint and all 13 configuration/query checks passed. The integration runner correctly refuses execution without RUN_DB_TESTS=1. No MySQL/MariaDB server was available, so database integration tests and database-backed examples remain **unrun**; their expected results above are targets, not executed results. Static review and local link/whitespace checks passed. PHP 8.1 and database-version compatibility have not been runtime-tested in this run.

## Exercises

1. Change an optional city from NULL to an empty string. Predict COUNT(city) and WHERE behavior.
2. Add a second course for Asha. Explain why joining students to enrollments duplicates her student fields.
3. Try an unknown sort name. Explain why rejecting it is safer than quoting it as a column.
4. Search for the literal text `20%`. Predict the escaped pattern `%20!%%`.
5. Explain why a failed enrollment must restore the seat and why AUTO_INCREMENT gaps are harmless.
6. Design keyset pagination using `(created_at, id)`, including what happens when timestamps tie.

## Troubleshooting and references

- `could not find driver`: enable pdo_mysql for the PHP executable used by CLI; Apache and CLI may load different php.ini files.
- `Connection refused`: check that the local server is running and the host/port match XAMPP.
- `Access denied`: verify the local account and grants. Do not disable authentication to fix it.
- Missing table/duplicate table: select the correct empty lab and import the schema once. Do not reset an existing project.
- An interrupted transaction may leave gaps in generated IDs, even when its data rolled back.

Official references: [PDO prepare](https://www.php.net/manual/en/pdo.prepare.php), [PDO fetch](https://www.php.net/manual/en/pdostatement.fetch.php), [rowCount](https://www.php.net/manual/en/pdostatement.rowcount.php), [PDO transactions](https://www.php.net/manual/en/pdo.transactions.php), [MySQLi prepared statements](https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php), [MySQL implicit commits](https://dev.mysql.com/doc/refman/8.4/en/implicit-commit.html).
