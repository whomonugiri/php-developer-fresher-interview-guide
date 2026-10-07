<?php
declare(strict_types=1);

// Run: php examples/one_time_tokens.php
// A compact model for reset, email verification and remember-me tokens.
// A real service must use a durable database, secure email delivery, rate limits,
// generic account-existence replies, and revoke sessions after password reset.
$pdo = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec('CREATE TABLE tokens (
    id INTEGER PRIMARY KEY,
    user_id INTEGER NOT NULL,
    purpose TEXT NOT NULL,
    token_hash TEXT UNIQUE NOT NULL,
    expires_at INTEGER NOT NULL
)');

function issue_token(PDO $pdo, int $userId, string $purpose, int $ttlSeconds): string
{
    $token = bin2hex(random_bytes(32));
    $stmt = $pdo->prepare('INSERT INTO tokens (user_id, purpose, token_hash, expires_at)
        VALUES (:user_id, :purpose, :token_hash, :expires_at)');
    $stmt->execute([
        'user_id' => $userId,
        'purpose' => $purpose,
        'token_hash' => hash('sha256', $token),
        'expires_at' => time() + $ttlSeconds,
    ]);
    return $token; // Send only to the intended browser/email; never log the raw token.
}

function consume_token(PDO $pdo, string $token, string $purpose): ?int
{
    if (!preg_match('/^[a-f0-9]{64}$/D', $token)) {
        return null;
    }
    $pdo->beginTransaction(); // Consume in one transaction; use row locks in other DBs.
    try {
        $stmt = $pdo->prepare('SELECT id, user_id, expires_at FROM tokens
            WHERE token_hash = :hash AND purpose = :purpose');
        $stmt->execute(['hash' => hash('sha256', $token), 'purpose' => $purpose]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!is_array($row) || (int) $row['expires_at'] <= time()) {
            $pdo->commit();
            return null;
        }
        $delete = $pdo->prepare('DELETE FROM tokens WHERE id = :id');
        $delete->execute(['id' => (int) $row['id']]);
        $pdo->commit();
        return (int) $row['user_id'];
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}

foreach (['password_reset' => 900, 'email_verify' => 3600, 'remember_me' => 86400] as $purpose => $ttl) {
    $token = issue_token($pdo, 1, $purpose, $ttl);
    echo $purpose . ': first use user ' . (consume_token($pdo, $token, $purpose) ?? 'none') . PHP_EOL;
    echo $purpose . ': second use ' . (consume_token($pdo, $token, $purpose) ?? 'rejected') . PHP_EOL;
}

// After a valid remember-me token, issue a replacement and rotate its browser
// cookie. A reset token instead authorizes a password change, followed by token
// and session revocation. An email token marks an address verified; it is not login.
