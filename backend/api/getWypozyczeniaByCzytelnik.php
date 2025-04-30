<?php
include '../Main/baza.php';
header('Content-Type: application/json');

if (isset($_GET['czytelnik_id'])) {
    $czytelnik_id = intval($_GET['czytelnik_id']);

    $stmt = $conn->prepare("SELECT wypozyczenie.id AS wypozyczenie_id, ksiazka.tytul, ksiazka.id AS ksiazka_id
                            FROM wypozyczenie
                            JOIN ksiazka ON wypozyczenie.ksiazka_id = ksiazka.id
                            WHERE wypozyczenie.czytelnik_id = ?");
    $stmt->bind_param("i", $czytelnik_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $wypozyczenia = [];

    while ($row = $result->fetch_assoc()) {
        $wypozyczenia[] = $row;
    }

    echo json_encode($wypozyczenia);
} else {
    echo json_encode([]);
}
?>
