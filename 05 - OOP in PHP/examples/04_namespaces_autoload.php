<?php
declare(strict_types=1);

// Run: php examples/04_namespaces_autoload.php
require dirname(__DIR__) . '/autoload.php';

use DevNinja\Part5\Invoice;

$invoice = new Invoice('INV-001', 1999);
echo $invoice->number . ': ' . $invoice->amountCents . " cents\n";
// Namespaces prevent name collisions; the loader maps a class name to its file.
