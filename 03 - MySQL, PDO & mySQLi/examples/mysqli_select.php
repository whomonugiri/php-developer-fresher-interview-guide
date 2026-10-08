<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
requireCli();
$c = databaseConfig();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli($c['host'], $c['user'], $c['password'], $c['name'], $c['port']);
$db->set_charset('utf8mb4');
$stmt = $db->prepare('SELECT name, email FROM students WHERE city = ? ORDER BY id');
$city = 'Delhi';
$stmt->bind_param('s', $city); // s=string, i=integer, d=double, b=binary
$stmt->execute();
// bind_result works without mysqlnd; get_result requires mysqlnd.
$stmt->bind_result($name, $email);
while ($stmt->fetch()) {
    echo "$name <$email>\n";
}
$stmt->close();
$db->close();
