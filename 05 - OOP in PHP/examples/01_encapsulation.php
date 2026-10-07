<?php
declare(strict_types=1);

// Run: php examples/01_encapsulation.php
// Money is stored as integer cents to avoid floating-point rounding surprises.
final class Account
{
    private int $balanceCents = 0;

    public function __construct(public readonly string $owner)
    {
        if (trim($owner) === '') {
            throw new InvalidArgumentException('Owner is required.');
        }
    }

    public function deposit(int $cents): void
    {
        if ($cents <= 0) {
            throw new InvalidArgumentException('Deposit must be positive.');
        }
        $this->balanceCents += $cents;
    }

    public function withdraw(int $cents): void
    {
        if ($cents <= 0 || $cents > $this->balanceCents) {
            throw new DomainException('Invalid withdrawal.');
        }
        $this->balanceCents -= $cents;
    }

    public function balanceCents(): int
    {
        return $this->balanceCents;
    }
}

$account = new Account('Learner');
$account->deposit(1500);
$account->withdraw(250);
echo $account->owner . ' has ' . $account->balanceCents() . " cents\n";
// Expected: Learner has 1250 cents
