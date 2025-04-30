<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php';

$result = $conn->query("SELECT id, CONCAT(imie, ' ', nazwisko) AS pelne_imie FROM czytelnik");
$czytelnicy = [];

while ($row = $result->fetch_assoc()) {
    $czytelnicy[] = $row;
}

echo json_encode($czytelnicy);
?>
