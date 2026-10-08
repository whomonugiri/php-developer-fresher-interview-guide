<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
requireCli();
$pdo = connectPdo();
// Roll back the teaching changes, including if a query fails. Auto-increment IDs may have gaps.
$pdo->beginTransaction();
try {
    $insert = $pdo->prepare('INSERT INTO students (name, email, city) VALUES (:name, :email, :city)');
    $insert->execute(['name' => 'Demo Learner', 'email' => 'demo-' . bin2hex(random_bytes(6)) . '@example.test', 'city' => 'Delhi']);
    $id = (int) $pdo->lastInsertId();
    echo "Inserted ID: $id (varies)\n";

    $select = $pdo->prepare('SELECT id, name, city FROM students WHERE id = :id');
    $select->execute(['id' => $id]);
    echo json_encode($select->fetch(), JSON_THROW_ON_ERROR) . "\n";

    $update = $pdo->prepare('UPDATE students SET city = :city WHERE id = :id');
    $update->execute(['city' => 'Pune', 'id' => $id]);
    echo 'Changed rows: ' . $update->rowCount() . "\n";
    $update->execute(['city' => 'Pune', 'id' => $id]);
    echo 'Same-value update: ' . $update->rowCount() . "\n";

    $delete = $pdo->prepare('DELETE FROM students WHERE id = :id');
    $delete->execute(['id' => $id]);
    echo 'Deleted rows: ' . $delete->rowCount() . "\n";
} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
}
echo "Demo changes rolled back.\n";
