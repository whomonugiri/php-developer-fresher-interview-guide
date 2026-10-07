<?php
declare(strict_types=1);

// Run: php examples/cookie_integrity.php
// This HMAC example demonstrates integrity only; the value is readable by anyone
// holding the cookie. Never store a role or another authorization decision here.
$key = random_bytes(32); // Ephemeral test key; production keys need protected storage/rotation.
$value = 'theme=dark';
$signature = hash_hmac('sha256', $value, $key);
$cookieValue = base64_encode($value) . '.' . $signature;

function verified_cookie(string $cookie, string $key): ?string
{
    $parts = explode('.', $cookie, 2);
    if (count($parts) !== 2 || !preg_match('/^[a-f0-9]{64}$/D', $parts[1])) {
        return null;
    }
    $value = base64_decode($parts[0], true);
    if ($value === false || !hash_equals(hash_hmac('sha256', $value, $key), $parts[1])) {
        return null;
    }
    return $value;
}

echo 'Original: ' . (verified_cookie($cookieValue, $key) ?? 'rejected') . PHP_EOL;
echo 'Changed: ' . (verified_cookie(base64_encode('theme=admin') . '.' . $signature, $key) ?? 'rejected') . PHP_EOL;
// Encryption additionally hides the value; use a vetted authenticated-encryption
// library when confidentiality is needed. Both require server-side authorization.
