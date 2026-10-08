<?php

declare(strict_types=1);

namespace PhpSeries\Fundamentals;

/**
 * Q: Where does PHP execute, and what does a browser receive?
 * A: A server can execute PHP and send its output (HTML, JSON, etc.). The CLI
 *    executes PHP without a web server. Correct server configuration is needed
 *    to keep source files private; PHP is not automatically secure.
 *
 * HTML text must be escaped for its output context. This helper is for HTML
 * text, not JavaScript, CSS, URLs, or SQL. See README.md for the request flow.
 */
function greetingHtml(string $name): string
{
    $escaped = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    return '<h1>Hello, ' . $escaped . '</h1>';
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    // Expected: <h1>Hello, Ada &amp; Lin</h1>
    echo greetingHtml('Ada & Lin'), PHP_EOL;
}
