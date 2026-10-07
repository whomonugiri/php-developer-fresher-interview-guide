<?php
declare(strict_types=1);

// Run: php examples/password_and_sql.php
// In-memory SQLite keeps this exercise independent of a production database.
$pdo = new PDO('sqlite::memory:', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT UNIQUE NOT NULL, password_hash TEXT NOT NULL)');

$email = 'learner@example.test';
$password = 'DemoPass!123'; // Teaching input only; do not hard-code real credentials.
$hash = password_hash($password, PASSWORD_DEFAULT);
$insert = $pdo->prepare('INSERT INTO users (email, password_hash) VALUES (:email, :hash)');
$insert->execute(['email' => $email, 'hash' => $hash]);

// Parameters are for values. SQL identifiers such as a table/column name need an allowlist.
$lookup = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = :email');
$lookup->execute(['email' => $email]);
$user = $lookup->fetch();
if (!is_array($user) || !password_verify($password, $user['password_hash'])) {
    throw new RuntimeException('Expected demo login to work.');
}
echo "Correct password: accepted\n";
echo 'Wrong password: ' . (password_verify('wrong', $user['password_hash']) ? 'accepted' : 'rejected') . "\n";
echo 'Needs rehash now: ' . (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT) ? 'yes' : 'no') . "\n";

$lookup->execute(['email' => "x' OR 1=1 --"]);
echo 'SQL injection input rows: ' . count($lookup->fetchAll()) . "\n";

// If a password policy or default hashing algorithm changes, update the stored
// hash after a successful login with password_needs_rehash() + password_hash().
