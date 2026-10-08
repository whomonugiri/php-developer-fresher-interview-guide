<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
require dirname(__DIR__) . '/queries.php';
requireCli();
$pdo = connectPdo();
// argv is only sample input; SQL structure comes exclusively from studentOrder().
$term = literalLike($argv[1] ?? 'a');
$sort = studentOrder($argv[2] ?? 'name');
$stmt = $pdo->prepare("SELECT name, city FROM students WHERE name LIKE :term ESCAPE '!' ORDER BY $sort LIMIT 20");
$stmt->execute(['term' => $term]);
while (($row = $stmt->fetch()) !== false) {
    echo json_encode($row, JSON_THROW_ON_ERROR) . "\n";
}
echo 'Total students: ' . (int) $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn() . "\n";
// fetchAll() would materialize all REMAINING rows, here none: the loop consumed them.
echo 'Remaining rows: ' . count($stmt->fetchAll()) . "\n";

$byReference = $pdo->prepare('SELECT name FROM students WHERE id = :id');
$id = 1;
$byReference->bindParam(':id', $id, PDO::PARAM_INT);
$id = 2;
$byReference->execute();
echo 'bindParam after reassignment: ' . $byReference->fetchColumn() . "\n";
$byValue = $pdo->prepare('SELECT name FROM students WHERE id = :id');
$id = 1;
$byValue->bindValue(':id', $id, PDO::PARAM_INT);
$id = 2;
$byValue->execute();
echo 'bindValue before reassignment: ' . $byValue->fetchColumn() . "\n";
