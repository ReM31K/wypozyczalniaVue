<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php'; 

$query = "SELECT autor.nazwisko, autor.imie FROM autor";

// Перевірка на помилки SQL-запиту
if ($result = $conn->query($query)) {
    $authors = [];
    while ($row = $result->fetch_assoc()) {
        $authors[] = [
            'nazwisko' => $row['nazwisko'],
            'imie' => $row['imie']
        ]; 
    }
    echo json_encode($authors); 
} else {
    // Якщо запит не вдалий, повертаємо помилку
    echo json_encode(['error' => 'Błąd SQL: ' . $conn->error]);
}
?>
