<?php
declare(strict_types=1);

// Run: php examples/input_json_dates.php
$input = ['present_null' => null, 'empty' => ''];
echo 'Absent key: ' . (array_key_exists('absent', $input) ? 'no' : 'yes') . PHP_EOL;
echo 'Present null: ' . (array_key_exists('present_null', $input) ? 'yes' : 'no') . PHP_EOL;
echo 'isset(null): ' . (isset($input['present_null']) ? 'yes' : 'no') . PHP_EOL;
echo 'Empty string: ' . ($input['empty'] === '' ? 'yes' : 'no') . PHP_EOL;
echo 'Fallback for absent/null: ' . ($input['absent'] ?? 'fallback') . PHP_EOL;

try {
    json_decode('{broken', true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $exception) {
    echo 'Invalid JSON caught: ' . $exception->getMessage() . PHP_EOL;
}
$json = json_encode(['message' => 'Keep learning, keep coding.'], JSON_THROW_ON_ERROR);
echo 'Valid JSON: ' . $json . PHP_EOL;

// Store/compare instants in UTC, then format for a user's named timezone.
$instant = new DateTimeImmutable('2026-10-07T12:00:00+00:00');
echo 'UTC: ' . $instant->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i T') . PHP_EOL;
echo 'Kolkata: ' . $instant->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('Y-m-d H:i T') . PHP_EOL;

$untrusted = '<script>alert(1)</script>';
echo 'HTML text: ' . htmlspecialchars($untrusted, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . PHP_EOL;
