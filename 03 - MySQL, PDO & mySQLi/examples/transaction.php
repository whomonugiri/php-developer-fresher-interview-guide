<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
require dirname(__DIR__) . '/queries.php';
requireCli();
$pdo = connectPdo();
$pdo->beginTransaction();
try {
    reserveSeat($pdo, 2, 1);
    echo "Reserved the final seat for Kabir inside this transaction.\n";
    // A real approved purchase flow would commit here. This lesson always rolls back.
} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
}
echo "Rolled back: the seat and enrollment are unchanged.\n";
