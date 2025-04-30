<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php';

$result = $conn->query("SELECT id, tytul FROM ksiazka");
$ksiazki = [];

while ($row = $result->fetch_assoc()) {
    $ksiazki[] = $row;
}

echo json_encode($ksiazki);
?>
