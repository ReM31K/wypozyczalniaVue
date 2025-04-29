<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT c.id, CONCAT(c.imie, ' ', c.nazwisko) AS pelne_imie, u.nazwa AS ulica, c.ulica_numer, c.mieszkanie_numer, c.email
                        FROM czytelnik c
                        JOIN ulica u ON c.ulica_id = u.id");

$czytelnicy = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $czytelnicy[] = $row;
    }
}

echo json_encode($czytelnicy);
?>
