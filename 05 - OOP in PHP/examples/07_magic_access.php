<?php
declare(strict_types=1);

// Run: php examples/07_magic_access.php
// Magic access can obscure property names and make typo detection harder.
// Explicit properties/getters are normally easier to understand and analyze.
final class MagicProfile
{
    /** @var array<string, string> */
    private array $fields = ['name' => 'Learner'];

    public function __get(string $name): string
    {
        if (!array_key_exists($name, $this->fields)) {
            throw new OutOfBoundsException('Unknown field: ' . $name);
        }
        return $this->fields[$name];
    }

    public function __set(string $name, mixed $value): void
    {
        if ($name !== 'name' || !is_string($value) || trim($value) === '') {
            throw new InvalidArgumentException('Invalid profile field.');
        }
        $this->fields[$name] = $value;
    }
}

$profile = new MagicProfile();
echo $profile->name . PHP_EOL;
$profile->name = 'Ninja';
echo $profile->name . PHP_EOL;
try {
    echo $profile->naem; // Demonstrate a misspelling caught by the guard.
} catch (OutOfBoundsException $exception) {
    echo 'Typo rejected: ' . $exception->getMessage() . PHP_EOL;
}
