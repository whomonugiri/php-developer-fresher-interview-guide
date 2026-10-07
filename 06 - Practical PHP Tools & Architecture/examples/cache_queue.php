<?php
declare(strict_types=1);

// Run: php examples/cache_queue.php
// Toy in-memory examples. Production caches and queues need shared, durable
// backends, safe serialization, limits, retries and monitoring.
final class ArrayTtlCache
{
    /** @var array<string, array{value: string, expires_at: int}> */
    private array $items = [];

    public function put(string $key, string $value, int $ttlSeconds, int $now): void
    {
        if ($ttlSeconds < 1) {
            throw new InvalidArgumentException('TTL must be positive.');
        }
        $this->items[$key] = ['value' => $value, 'expires_at' => $now + $ttlSeconds];
    }

    public function get(string $key, int $now): ?string
    {
        $item = $this->items[$key] ?? null;
        return $item !== null && $now < $item['expires_at'] ? $item['value'] : null;
    }
}

$cache = new ArrayTtlCache();
$cache->put('book:1', 'PHP Basics', 10, 100);
echo 'Cache at t=105: ' . ($cache->get('book:1', 105) ?? 'miss') . PHP_EOL;
echo 'Cache at t=110: ' . ($cache->get('book:1', 110) ?? 'miss') . PHP_EOL;
// A write to book:1 should also invalidate/update its cached value.

$queue = new SplQueue();
$queue->enqueue(['type' => 'welcome_email', 'user_id' => 1]);
echo 'Request: queued a job, without sending mail' . PHP_EOL;
while (!$queue->isEmpty()) {
    $job = $queue->dequeue();
    echo 'Worker: processed ' . $job['type'] . ' for user ' . $job['user_id'] . PHP_EOL;
}
// A real queue worker needs a durable message store, retries, dead-letter
// handling and idempotent processing; this process-local queue has none of them.
