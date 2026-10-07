<?php
declare(strict_types=1);

namespace DevNinja\Part6;

final readonly class Response
{
    public function __construct(public int $status, public string $contentType, public string $body)
    {
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: ' . $this->contentType);
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: no-store');
        echo $this->body;
    }
}
