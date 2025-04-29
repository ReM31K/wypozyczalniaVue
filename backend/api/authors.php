<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include '../Main/baza.php'; 

$query = "
    SELECT ksiazka.id, autor.nazwisko, autor.imie, 
    COALESCE(ksiazka.tytul, 'Brak książki') AS tytul, 
    COALESCE(CAST(ksiazka.rok_wydania AS CHAR), '-') AS rok_wydania
    FROM autor
    LEFT JOIN ksiazka ON autor.id = ksiazka.autor_id
    ORDER BY ksiazka.id ASC
";

$result = $conn->query($query);

$authors = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row; 
    }
}

echo json_encode($authors); 
?>
