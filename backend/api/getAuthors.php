<?php
include '../Main/baza.php';

// Отримуємо список авторів для вибору
$authors_result = $conn->query("SELECT id, CONCAT(imie, ' ', nazwisko) AS pelne_imie FROM autor");

if ($authors_result) {
    $authors = [];
    while ($row = $authors_result->fetch_assoc()) {
        $authors[] = $row;
    }
    echo json_encode($authors);
} else {
    echo json_encode(["error" => "Błąd przy pobieraniu autorów"]);
}
?>
