<?php
declare(strict_types=1);

namespace DevNinja\Part5;

final readonly class Invoice
{
    public function __construct(public string $number, public int $amountCents)
    {
        if ($number === '' || $amountCents < 0) {
            throw new \InvalidArgumentException('Invalid invoice.');
        }
    }
}
