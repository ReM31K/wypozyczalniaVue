<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Отримати JSON з тіла запиту
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$haslo = $data['haslo'] ?? '';

// Тут мала би бути перевірка користувача в базі даних.
// Тестово просто імітуємо успішний логін:
if ($email === 'admin@example.com' && $haslo === 'admin123') {
    echo json_encode([
        'status' => 'success',
        'role' => 'admin'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Nieprawidłowy login lub hasło.'
    ]);
}
