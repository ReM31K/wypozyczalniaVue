<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php';

$result = $conn->query("SELECT k.id, k.tytul, CONCAT(a.imie, ' ', a.nazwisko) AS autor, 
                               w.nazwa AS wydawca, t.nazwa AS tematyka, 
                               k.rok_wydania, k.ilosc_dostepnych, k.ilosc_calkowita
                        FROM ksiazka k
                        JOIN autor a ON k.autor_id = a.id
                        JOIN wydawca w ON k.wydawca_id = w.id
                        JOIN tematyka t ON k.tematyka_id = t.id");


$books = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = [
            'id' => $row['id'],
            'tytul' => $row['tytul'],
            'autor' => $row['autor'],
            'wydawca' => $row['wydawca'],
            'tematyka' => $row['tematyka'],
            'rok_wydania' => $row['rok_wydania'],
            'ilosc_calkowita' => $row['ilosc_calkowita'],
            'ilosc_dostepnych' => $row['ilosc_dostepnych']
        ];
    }
} else {
    $books = [];
}

echo json_encode($books);
?>
