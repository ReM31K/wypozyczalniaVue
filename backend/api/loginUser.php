<?php
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../Main/baza.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

// ======= DEBUG LOGGING START =======
$logFile = __DIR__ . '/log.txt';
file_put_contents($logFile, "REQUEST METHOD: " . $_SERVER["REQUEST_METHOD"] . PHP_EOL, FILE_APPEND);

$raw_input = file_get_contents('php://input');
file_put_contents($logFile, "RAW INPUT: " . $raw_input . PHP_EOL, FILE_APPEND);

// Перевірка, чи правильно розпарсились дані
$input = json_decode($raw_input, true);
file_put_contents($logFile, "PARSED INPUT: " . print_r($input, true) . PHP_EOL, FILE_APPEND);


try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $input = json_decode($raw_input, true);
        file_put_contents($logFile, "PARSED INPUT: " . print_r($input, true) . PHP_EOL, FILE_APPEND);

        if (!$input || !isset($input['email']) || !isset($input['haslo'])) {
            echo json_encode(['status' => 'error', 'message' => 'Brak wymaganych danych.']);
            exit;
        }

        $email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
        $haslo = $input['haslo'];

        // USER
        $stmt_user = $conn->prepare("SELECT id, imie, nazwisko, haslo FROM czytelnik WHERE email = ?");
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $stmt_user->store_result();

        if ($stmt_user->num_rows > 0) {
            $stmt_user->bind_result($id, $imie, $nazwisko, $hashed_password);
            $stmt_user->fetch();

            if (password_verify($haslo, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = "$imie $nazwisko";

                echo json_encode([
                    'status' => 'success',
                    'role' => 'user',
                    'name' => $_SESSION['user_name']
                ]);
                exit;
            }
        }

        // ADMIN
        $stmt_admin = $conn->prepare("SELECT id, imie, nazwisko, haslo FROM adminLog WHERE email = ?");
        $stmt_admin->bind_param("s", $email);
        $stmt_admin->execute();
        $stmt_admin->store_result();

        if ($stmt_admin->num_rows > 0) {
            $stmt_admin->bind_result($admin_id, $admin_imie, $admin_nazwisko, $admin_hashed_password);
            $stmt_admin->fetch();

            if (password_verify($haslo, $admin_hashed_password)) {
                $_SESSION['adminLog_id'] = $admin_id;
                $_SESSION['adminLog_name'] = "$admin_imie $admin_nazwisko";

                echo json_encode([
                    'status' => 'success',
                    'role' => 'admin',
                    'name' => $_SESSION['adminLog_name']
                ]);
                exit;
            }
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Nieprawidłowy email lub hasło.'
        ]);
    } elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
        echo json_encode(['status' => 'OK', 'message' => 'To jest GET-test']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Zły typ zapytania.']);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Błąd serwera: ' . $e->getMessage()
    ]);
}
