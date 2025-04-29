<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type"); // дозволяє заголовок Content-Type для запитів

// Обробка preflight запитів
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // якщо метод OPTIONS, просто повертаємо успіх
}

include '../Main/baza.php';

// Перевіряємо, чи є запит POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Отримуємо JSON з запиту
    $data = json_decode(file_get_contents("php://input"), true);

    // Перевірка необхідних даних
    if (!isset($data['tytul']) || !isset($data['autor_id']) || !isset($data['wydawca']) || !isset($data['tematyka']) || !isset($data['rok_wydania']) || !isset($data['ilosc_calkowita'])) {
        echo json_encode(["error" => "Brak wymaganych danych"]);
        exit();
    }

    $tytul = htmlspecialchars(trim($data['tytul']));
    $autor_id = intval($data['autor_id']);
    $wydawca = htmlspecialchars(trim($data['wydawca']));
    $tematyka = htmlspecialchars(trim($data['tematyka']));
    $rok_wydania = intval($data['rok_wydania']);
    $ilosc_calkowita = intval($data['ilosc_calkowita']);
    $ilosc_dostepnych = $ilosc_calkowita;  // Початково всі книги доступні

    // Перевірка року видання
    if ($rok_wydania <= 0) {
        echo json_encode(["error" => "Nieprawidłowy rok wydania"]);
        exit();
    }

    // Додаємо видавця (якщо його немає)
    $stmt = $conn->prepare("SELECT id FROM wydawca WHERE nazwa = ?");
    $stmt->bind_param("s", $wydawca);
    $stmt->execute();
    $stmt->bind_result($wydawca_id);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO wydawca (nazwa) VALUES (?)");
        $stmt->bind_param("s", $wydawca);
        $stmt->execute();
        $wydawca_id = $stmt->insert_id;
    }
    $stmt->close();

    // Додаємо тематику (якщо її немає)
    $stmt = $conn->prepare("SELECT id FROM tematyka WHERE nazwa = ?");
    $stmt->bind_param("s", $tematyka);
    $stmt->execute();
    $stmt->bind_result($tematyka_id);
    if (!$stmt->fetch()) {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO tematyka (nazwa) VALUES (?)");
        $stmt->bind_param("s", $tematyka);
        $stmt->execute();
        $tematyka_id = $stmt->insert_id;
    }
    $stmt->close();

    // Додаємо книгу
    $stmt = $conn->prepare("INSERT INTO ksiazka (tytul, autor_id, wydawca_id, tematyka_id, rok_wydania, ilosc_calkowita, ilosc_dostepnych) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiiii", $tytul, $autor_id, $wydawca_id, $tematyka_id, $rok_wydania, $ilosc_calkowita, $ilosc_dostepnych);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Książka została dodana"]);
    } else {
        echo json_encode(["error" => "Błąd serwera przy dodawaniu książki"]);
    }

    $stmt->close();
}
?>
