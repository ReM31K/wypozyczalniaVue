<?php
include '../Main/baza.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['wypozyczenie_id']) || !isset($data['ksiazka_id'])) {
    echo json_encode(['success' => false, 'error' => 'Brakuje danych wejściowych']);
    exit;
}

$wypozyczenie_id = intval($data['wypozyczenie_id']);
$ksiazka_id = intval($data['ksiazka_id']);

$stmt = $conn->prepare("DELETE FROM wypozyczenie WHERE id = ?");
$stmt->bind_param("i", $wypozyczenie_id);

if ($stmt->execute()) {
    $updateStmt = $conn->prepare("UPDATE ksiazka SET ilosc_dostepnych = ilosc_dostepnych + 1 WHERE id = ?");
    $updateStmt->bind_param("i", $ksiazka_id);

    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Książka zwrócona pomyślnie']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Błąd przy aktualizacji książki']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Błąd przy usuwaniu wypożyczenia']);
}
?>
