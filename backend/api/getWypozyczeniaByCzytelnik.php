<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
include '../Main/baza.php';

$czytelnik_id = intval($_GET['czytelnik_id'] ?? 0);

$stmt = $conn->prepare("
    SELECT w.id AS wypozyczenie_id, k.id AS ksiazka_id, k.tytul, k.rok_wydania, CONCAT(a.imie, ' ', a.nazwisko) as autor
    FROM wypozyczenie w
    JOIN ksiazka k ON w.ksiazka_id = k.id
    JOIN autor a ON k.autor_id = a.id
    WHERE w.czytelnik_id = ?
");
$stmt->bind_param("i", $czytelnik_id);
$stmt->execute();

$result = $stmt->get_result();
$wypozyczenia = [];

while ($row = $result->fetch_assoc()) {
    $wypozyczenia[] = $row;
}

echo json_encode($wypozyczenia);
