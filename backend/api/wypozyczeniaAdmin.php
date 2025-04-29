<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php';

$query = "
    SELECT w.id, CONCAT(c.imie, ' ', c.nazwisko) AS pelne_imie, k.tytul AS ksiazka
    FROM wypozyczenie w
    JOIN czytelnik c ON w.czytelnik_id = c.id
    JOIN ksiazka k ON w.ksiazka_id = k.id
    ORDER BY w.id ASC
";

$result = $conn->query($query);
$wypozyczenia = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wypozyczenia[] = $row;
    }
}

echo json_encode($wypozyczenia);
