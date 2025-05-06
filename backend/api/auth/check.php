<?php
session_start();

header('Content-Type: application/json');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

if (isset($_SESSION['adminLog_id'])) {
    // Якщо це адмін
    echo json_encode([
        'authenticated' => true,
        'role' => 'admin',
        'adminLog_id' => $_SESSION['adminLog_id']
    ]);
} elseif (isset($_SESSION['user_id'])) {
    // Якщо це звичайний користувач
    echo json_encode([
        'authenticated' => true,
        'role' => 'user',
        'user_id' => $_SESSION['user_id']
    ]);
} else {
    echo json_encode([
        'authenticated' => false
    ]);
}
