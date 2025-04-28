<?php
include '../Main/baza.php';  // Підключення до бази даних

// Встановлюємо заголовки для JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Виконуємо SQL запит до бази даних
$result = $conn->query("SELECT k.id, k.tytul, CONCAT(a.imie, ' ', a.nazwisko) AS autor, w.nazwa AS wydawca, t.nazwa AS tematyka, 
                                   k.rok_wydania, k.ilosc_dostepnych, k.dostepnosc
                          FROM ksiazka k
                          JOIN autor a ON k.autor_id = a.id
                          JOIN wydawca w ON k.wydawca_id = w.id
                          JOIN tematyka t ON k.tematyka_id = t.id");

$books = [];  // Масив для зберігання книг

if ($result->num_rows > 0) {
    // Якщо є результати, збираємо їх в масив
    while ($row = $result->fetch_assoc()) {
        $books[] = [
            'id' => $row['id'],
            'tytul' => $row['tytul'],
            'autor' => $row['autor'],
            'wydawca' => $row['wydawca'],
            'tematyka' => $row['tematyka'],
            'rok_wydania' => $row['rok_wydania'],
            'dostepnosc' => ($row['ilosc_dostepnych'] == 0) ? "Nie" : "Tak"
        ];
    }
} else {
    $books = [];  // Якщо немає записів, повертаємо порожній масив
}

// Виводимо дані у форматі JSON
echo json_encode($books);
?>
