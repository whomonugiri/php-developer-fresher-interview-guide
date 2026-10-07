<?php
declare(strict_types=1);

// Run: php examples/05_object_features.php
class BaseRecord
{
    public string $uninitialized; // Access before assignment raises an Error.
    public ?string $optional = null; // Explicitly initialized.
    private static int $created = 0;

    public function __construct()
    {
        self::$created++;
    }

    public static function createdCount(): int
    {
        return self::$created;
    }

    public function identity(): string
    {
        return self::class . ' / ' . static::class . ' / ' . $this::class;
    }
}

final class ChildRecord extends BaseRecord
{
    public function identity(): string
    {
        return 'child: ' . parent::identity();
    }
}

trait FirstLabel
{
    public function label(): string { return 'first'; }
}
trait SecondLabel
{
    public function label(): string { return 'second'; }
}
final class Labelled
{
    use FirstLabel, SecondLabel {
        FirstLabel::label insteadof SecondLabel;
        SecondLabel::label as alternateLabel;
    }
}

final class DisplayName
{
    public function __construct(public string $name)
    {
    }

    public function __toString(): string
    {
        return $this->name; // Do not include secrets in a string representation.
    }
}

final class Box
{
    public function __construct(public DisplayName $item)
    {
    }
}

$child = new ChildRecord();
echo 'Typed property initialized: ' . (isset($child->uninitialized) ? 'yes' : 'no') . PHP_EOL;
echo 'self / static / this: ' . $child->identity() . PHP_EOL;
echo 'Objects created: ' . BaseRecord::createdCount() . PHP_EOL;
$label = new Labelled();
echo 'Trait conflict: ' . $label->label() . ' / ' . $label->alternateLabel() . PHP_EOL;
$first = new DisplayName('Book');
$second = new DisplayName('Book');
echo 'Object == / ===: ' . ($first == $second ? 'true' : 'false') . ' / ' . ($first === $second ? 'true' : 'false') . PHP_EOL;
echo 'String representation: ' . $first . PHP_EOL;
$original = new Box(new DisplayName('Before'));
$copy = clone $original; // The nested DisplayName remains shared (shallow clone).
$copy->item->name = 'After';
echo 'Original after shallow clone change: ' . $original->item->name . PHP_EOL;
