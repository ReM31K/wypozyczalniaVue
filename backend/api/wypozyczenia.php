<?php
session_start();
header('Content-Type: application/json');

include '../Main/baza.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT k.tytul, k.rok_wydania, CONCAT(a.imie, ' ', a.nazwisko) AS autor
          FROM wypozyczenie w
          JOIN ksiazka k ON w.ksiazka_id = k.id
          JOIN autor a ON k.autor_id = a.id
          WHERE w.czytelnik_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$books = [];

while ($row = $result->fetch_assoc()) {
    $books[] = [
        'tytul' => $row['tytul'],
        'rok_wydania' => $row['rok_wydania'],
        'autor' => $row['autor'],
    ];
}

echo json_encode($books);
$conn->close();
