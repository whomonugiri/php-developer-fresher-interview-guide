<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
require dirname(__DIR__) . '/queries.php';
requireCli();
if (getenv('RUN_DB_TESTS') !== '1') {
    fwrite(STDERR, "Set RUN_DB_TESTS=1 only for the disposable local lab. No tests ran.\n");
    exit(2);
}
function check(bool $condition, string $message): void {
    if (!$condition) { throw new RuntimeException($message); }
}
$pdo = connectPdo();
$pdo->beginTransaction();
try {
    $suffix = bin2hex(random_bytes(8));
    $insert = $pdo->prepare('INSERT INTO students (name,email,city) VALUES (?,?,?)');
    $email = "test-$suffix@example.test";
    $insert->execute(['Test One', $email, null]);
    $first = (int) $pdo->lastInsertId();
    $insert->execute(['Test Two', "test2-$suffix@example.test", 'Delhi']);
    $second = (int) $pdo->lastInsertId();
    check($first > 0 && $second > $first, 'Generated IDs');
    try {
        $insert->execute(['Duplicate', $email, 'Pune']);
        throw new RuntimeException('Duplicate email accepted');
    } catch (PDOException $e) {
        check((int) ($e->errorInfo[1] ?? 0) === 1062, 'Expected duplicate-key error');
    }
    $search = $pdo->prepare('SELECT COUNT(*) FROM students WHERE email = ?');
    $search->execute(["' OR 1=1 -- "]);
    check((int) $search->fetchColumn() === 0, 'Injection string must be treated as data');
    $course = $pdo->prepare('INSERT INTO courses (title,seats) VALUES (?,1)');
    $course->execute(["Test course $suffix"]);
    $courseId = (int) $pdo->lastInsertId();
    reserveSeat($pdo, $first, $courseId);
    try {
        reserveSeat($pdo, $second, $courseId);
        throw new LogicException('Oversold the final seat');
    } catch (RuntimeException $e) {
        check($e->getMessage() === 'Course missing or sold out.', 'Expected sold-out failure');
    }
    $count = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE course_id = ?');
    $count->execute([$courseId]);
    check((int) $count->fetchColumn() === 1, 'One enrollment only');
    check(count(studentPage($pdo, 1, 2)) === 2, 'Bound integer LIMIT/OFFSET');
    // Restore a seat temporarily, then deliberately fail the duplicate enrollment.
    $pdo->exec('SAVEPOINT before_failed_enrollment');
    $restore = $pdo->prepare('UPDATE courses SET seats = 1 WHERE id = ?');
    $restore->execute([$courseId]);
    $pdo->exec('SAVEPOINT with_available_seat');
    try {
        reserveSeat($pdo, $first, $courseId);
        throw new RuntimeException('Duplicate enrollment accepted');
    } catch (PDOException $e) {
        check((int) ($e->errorInfo[1] ?? 0) === 1062, 'Expected duplicate enrollment');
        $pdo->exec('ROLLBACK TO SAVEPOINT with_available_seat');
    }
    $remaining = $pdo->prepare('SELECT seats FROM courses WHERE id = ?');
    $remaining->execute([$courseId]);
    check((int) $remaining->fetchColumn() === 1, 'Failed enrollment restores seat on rollback');
    $pdo->exec('ROLLBACK TO SAVEPOINT before_failed_enrollment');
} finally {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
}
$search->execute([$email]);
check((int) $search->fetchColumn() === 0, 'Fixture rolled back');
echo "Part 3 database integration checks passed; fixtures rolled back.\n";
