<?php
declare(strict_types=1);

function pagination(int $page, int $perPage): array
{
    if ($page < 1 || $perPage < 1 || $perPage > 100 || $page > 1000000) {
        throw new InvalidArgumentException('Page must be 1..1000000 and page size 1..100.');
    }
    return ['limit' => $perPage, 'offset' => ($page - 1) * $perPage];
}

function studentOrder(string $requested): string
{
    // Identifiers cannot be bound as data: map an external choice to constant SQL.
    return match ($requested) {
        'name' => 'name ASC, id ASC',
        'newest' => 'created_at DESC, id DESC',
        default => throw new InvalidArgumentException('Unsupported sort order.'),
    };
}

function studentPage(PDO $pdo, int $page, int $perPage, string $sort = 'name'): array
{
    $bounds = pagination($page, $perPage);
    $stmt = $pdo->prepare('SELECT id, name, city FROM students ORDER BY ' . studentOrder($sort) . ' LIMIT :limit OFFSET :offset');
    $stmt->bindValue(':limit', $bounds['limit'], PDO::PARAM_INT);
    $stmt->bindValue(':offset', $bounds['offset'], PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Caller owns the transaction so multiple related operations stay atomic.
function reserveSeat(PDO $pdo, int $studentId, int $courseId): void
{
    if (!$pdo->inTransaction()) {
        throw new LogicException('Begin a transaction before reserving a seat.');
    }
    $seat = $pdo->prepare('UPDATE courses SET seats = seats - 1 WHERE id = :id AND seats > 0');
    $seat->execute(['id' => $courseId]);
    if ($seat->rowCount() !== 1) {
        throw new RuntimeException('Course missing or sold out.');
    }
    $insert = $pdo->prepare('INSERT INTO enrollments (student_id, course_id) VALUES (:student, :course)');
    $insert->execute(['student' => $studentId, 'course' => $courseId]);
    // A duplicate/FK failure must make the caller roll back the seat decrement too.
}

function literalLike(string $input): string
{
    // SQL must use the same explicit escape character: LIKE :term ESCAPE '!'.
    return '%' . strtr($input, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
}
