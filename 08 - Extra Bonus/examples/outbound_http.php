<?php
declare(strict_types=1);

// This file DEFINES a safe starting pattern; running it does not make a request.
// The placeholder host represents an application-owned allowlist. Replace it
// with a real approved endpoint; validate the response schema for that API.
function fetchJsonFromTrustedUrl(string $url): array
{
    $parts = parse_url($url);
    if (!extension_loaded('curl') || !is_array($parts)
        || ($parts['scheme'] ?? null) !== 'https'
        || ($parts['host'] ?? null) !== 'api.example.test'
        || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])) {
        throw new InvalidArgumentException('An approved HTTPS endpoint is required.');
    }
    $handle = curl_init($url);
    if ($handle === false) {
        throw new RuntimeException('Could not initialize HTTP request.');
    }
    try {
        curl_setopt_array($handle, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_MAXREDIRS => 0,
        ]);
        $body = curl_exec($handle);
        $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
        if (!is_string($body) || $status < 200 || $status >= 300) {
            throw new RuntimeException('Upstream request failed.');
        }
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new UnexpectedValueException('Expected a JSON object or array.');
        }
        return $data;
    } finally {
        curl_close($handle);
    }
}

echo "No network request made. Call fetchJsonFromTrustedUrl() only for a trusted endpoint.\n";
