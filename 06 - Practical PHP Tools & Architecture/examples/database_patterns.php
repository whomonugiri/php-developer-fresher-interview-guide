<?php
declare(strict_types=1);

// Run: php examples/database_patterns.php
// All data exists only in this in-memory SQLite connection.
$pdo = new PDO('sqlite::memory:', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$pdo->exec('CREATE TABLE authors (id INTEGER PRIMARY KEY, name TEXT NOT NULL)');
$pdo->exec('CREATE TABLE books (id INTEGER PRIMARY KEY, author_id INTEGER NOT NULL, title TEXT NOT NULL)');
$pdo->exec('CREATE TABLE wallets (id INTEGER PRIMARY KEY, balance_cents INTEGER NOT NULL)');
$pdo->exec("INSERT INTO authors VALUES (1, 'Ana'), (2, 'Bo')");
$pdo->exec("INSERT INTO books VALUES (1, 1, 'PHP Basics'), (2, 1, 'PHP Objects'), (3, 2, 'Secure PHP')");
$pdo->exec('INSERT INTO wallets VALUES (1, 1000), (2, 500)');

// One JOIN fetches related names in a batch. Querying the author separately for
// every book would make 1 + N queries (the N+1 problem).
$rows = $pdo->query('SELECT b.id, b.title, a.name AS author
    FROM books AS b JOIN authors AS a ON a.id = b.author_id ORDER BY b.id')->fetchAll();
echo 'Batch book rows: ' . count($rows) . ' (one query)' . PHP_EOL;

// A transaction keeps this two-wallet transfer all-or-nothing.
$pdo->beginTransaction();
try {
    $debit = $pdo->prepare('UPDATE wallets SET balance_cents = balance_cents - :amount
        WHERE id = :id AND balance_cents >= :minimum');
    $debit->execute(['amount' => 250, 'id' => 1, 'minimum' => 250]);
    if ($debit->rowCount() !== 1) {
        throw new RuntimeException('Insufficient balance.');
    }
    $credit = $pdo->prepare('UPDATE wallets SET balance_cents = balance_cents + :amount WHERE id = :id');
    $credit->execute(['amount' => 250, 'id' => 2]);
    if ($credit->rowCount() !== 1) {
        throw new RuntimeException('Recipient not found.');
    }
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}
$balances = $pdo->query('SELECT balance_cents FROM wallets ORDER BY id')->fetchAll(PDO::FETCH_COLUMN);
echo 'Balances after transfer: ' . implode(', ', $balances) . PHP_EOL;

// Keyset pagination asks for IDs after the last seen ID; it is steadier than
// OFFSET when earlier rows are inserted or removed between requests.
$cursor = 1;
$page = $pdo->prepare('SELECT id, title FROM books WHERE id > :cursor ORDER BY id LIMIT 2');
$page->bindValue(':cursor', $cursor, PDO::PARAM_INT);
$page->execute();
$books = $page->fetchAll();
echo 'IDs after cursor 1: ' . implode(', ', array_column($books, 'id')) . PHP_EOL;
