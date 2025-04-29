<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Nieprawidłowa metoda żądania.'
    ]);
    exit;
}

$imie = $_POST['imie'] ?? '';
$nazwisko = $_POST['nazwisko'] ?? '';
$email = $_POST['email'] ?? '';
$haslo = password_hash($_POST['haslo'] ?? '', PASSWORD_DEFAULT);
$ulicaNazwa = $_POST['ulica_nazwa'] ?? '';
$ulicaNumer = $_POST['ulica_numer'] ?? '';
$mieszkanieNumer = $_POST['mieszkanie_numer'] ?? '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=wypozyczalnia;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 🔍 Знаходимо або додаємо вулицю
    $stmt = $pdo->prepare('SELECT id FROM ulica WHERE nazwa = ?');
    $stmt->execute([$ulicaNazwa]);
    $ulica = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ulica) {
        $ulicaId = $ulica['id'];
    } else {
        $stmt = $pdo->prepare('INSERT INTO ulica (nazwa) VALUES (?)');
        $stmt->execute([$ulicaNazwa]);
        $ulicaId = $pdo->lastInsertId();
    }

    // ✅ Тепер вставляємо читача
    $stmt = $pdo->prepare('INSERT INTO czytelnik (imie, nazwisko, email, haslo, ulica_id, ulica_numer, mieszkanie_numer) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$imie, $nazwisko, $email, $haslo, $ulicaId, $ulicaNumer, $mieszkanieNumer]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Użytkownik został zarejestrowany pomyślnie.'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Błąd bazy danych: ' . $e->getMessage()
    ]);
}
