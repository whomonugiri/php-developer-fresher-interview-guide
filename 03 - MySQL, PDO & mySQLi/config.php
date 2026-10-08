<?php
declare(strict_types=1);

// CLI-only teaching examples. Credentials stay in the process environment.
function databaseConfig(): array
{
    $configuredName = getenv('DB_NAME');
    $name = $configuredName === false || $configuredName === '' ? 'php_interview_lab' : $configuredName;
    if ($name !== 'php_interview_lab') {
        throw new RuntimeException('These lessons only use the disposable php_interview_lab database.');
    }
    $password = getenv('DB_PASSWORD');
    return [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('DB_PORT') ?: '3306'),
        'name' => $name,
        'user' => getenv('DB_USER') ?: 'php_learner',
        'password' => $password === false ? '' : $password,
    ];
}

function connectPdo(): PDO
{
    $c = databaseConfig();
    return new PDO(
        "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset=utf8mb4",
        $c['user'],
        $c['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
}

function requireCli(): void
{
    if (PHP_SAPI !== 'cli') {
        http_response_code(403);
        exit('Run this lesson from the command line.');
    }
}
