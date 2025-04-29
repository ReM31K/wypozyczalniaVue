<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type"); // дозволяє заголовок Content-Type для запитів
header("Access-Control-Max-Age: 3600"); // кешування preflight запитів на 1 годину

// Обробка preflight запитів
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0); // якщо метод OPTIONS, просто повертаємо успіх
}

include '../Main/baza.php';

// Отримуємо дані JSON з запиту
$data = json_decode(file_get_contents("php://input"), true);

// Перевіряємо, чи є необхідні дані
if (!isset($data['imie']) || !isset($data['nazwisko'])) {
    http_response_code(400); // Код помилки
    echo json_encode(["error" => "Brak wymaganych danych"]);
    exit();
}

$imie = htmlspecialchars(trim($data['imie']));
$nazwisko = htmlspecialchars(trim($data['nazwisko']));

// Перевіряємо формат імені та прізвища
if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+$/u", $imie)) {
    http_response_code(400);
    echo json_encode(["error" => "Nieprawidłowe imię"]);
    exit();
}
if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s-]+$/u", $nazwisko)) {
    http_response_code(400);
    echo json_encode(["error" => "Nieprawidłowe nazwisko"]);
    exit();
}

// Підготовка SQL-запиту для додавання автора
$stmt = $conn->prepare("INSERT INTO autor (imie, nazwisko) VALUES (?, ?)");
$stmt->bind_param("ss", $imie, $nazwisko);

// Виконання запиту
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Autor został dodany"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Błąd serwera przy dodawaniu autora"]);
}
?>
