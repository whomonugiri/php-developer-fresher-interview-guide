<?php
declare(strict_types=1);

// Run: php examples/06_types_enum_attributes.php
enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
}

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Label
{
    public function __construct(public string $text)
    {
    }
}

#[Label('Customer order')]
final class Order
{
    public function __construct(public OrderStatus $status)
    {
    }
}

final class InvalidOrderState extends DomainException
{
}

function normalizeReference(int|string $value): ?string
{
    $text = trim((string) $value);
    return $text === '' ? null : $text;
}

$order = new Order(OrderStatus::Pending);
$reflection = new ReflectionClass($order);
$attribute = $reflection->getAttributes(Label::class)[0]->newInstance();
echo $attribute->text . ': ' . $order->status->value . PHP_EOL;
echo 'Nullable result: ' . (normalizeReference('  ') ?? 'null') . PHP_EOL;
echo 'Union input: ' . normalizeReference(42) . PHP_EOL;
try {
    throw new InvalidOrderState('Payment is required.');
} catch (InvalidOrderState $exception) {
    echo 'Caught domain error: ' . $exception->getMessage() . PHP_EOL;
} finally {
    echo "Cleanup always runs.\n";
}
