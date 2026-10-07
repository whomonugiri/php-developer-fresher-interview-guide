<?php
declare(strict_types=1);

// Run: php examples/02_polymorphism.php
interface Notifier
{
    public function send(string $message): void;
}

final class ConsoleNotifier implements Notifier
{
    public function send(string $message): void
    {
        echo "NOTICE: {$message}\n";
    }
}

final class RecordingNotifier implements Notifier
{
    /** @var list<string> */
    public array $messages = [];

    public function send(string $message): void
    {
        $this->messages[] = $message;
    }
}

final class RegistrationService
{
    public function __construct(private Notifier $notifier)
    {
    }

    public function register(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email format.');
        }
        // In an application, save the user in a repository before notifying.
        $this->notifier->send('Welcome, ' . $email);
    }
}

(new RegistrationService(new ConsoleNotifier()))->register('learner@example.test');
$fake = new RecordingNotifier();
(new RegistrationService($fake))->register('test@example.test');
if ($fake->messages !== ['Welcome, test@example.test']) {
    throw new RuntimeException('Expected one welcome message.');
}
echo 'Recorded: ' . count($fake->messages) . " notification\n";
// Both implementations satisfy one interface; the service depends on the contract.
