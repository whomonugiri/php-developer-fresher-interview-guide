<?php
declare(strict_types=1);

// Run: php examples/03_inheritance_traits.php
trait HasLabel
{
    public function label(): string
    {
        return $this->name();
    }
}

abstract class Shape
{
    use HasLabel;

    public function __construct(protected string $name)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    abstract public function area(): float;
}

final class Rectangle extends Shape
{
    public function __construct(private float $width, private float $height)
    {
        if ($width <= 0 || $height <= 0) {
            throw new InvalidArgumentException('Dimensions must be positive.');
        }
        parent::__construct('rectangle');
    }

    public function area(): float
    {
        return $this->width * $this->height;
    }
}

$shape = new Rectangle(3, 4);
echo $shape->label() . ' area: ' . $shape->area() . PHP_EOL;
// A trait shares method implementation; it is not a substitute for an interface.
