<?php
function load_breeds(PDO $pdo): array {
    $st = $pdo->query("SELECT id, name FROM breeds ORDER BY name ASC");
    return $st->fetchAll();
}
