<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

include '../Main/baza.php';

$data = json_decode(file_get_contents("php://input"), true);
$czytelnik_id = intval($data['czytelnik_id']);
$ksiazka_id = intval($data['ksiazka_id']);
$ilosc_pozyczona = intval($data['ilosc']);

$stmt = $conn->prepare("SELECT ilosc_dostepnych FROM ksiazka WHERE id = ?");
$stmt->bind_param("i", $ksiazka_id);
$stmt->execute();
$result = $stmt->get_result();
$ksiazka = $result->fetch_assoc();

if (!$ksiazka) {
    echo json_encode(["error" => "Nie znaleziono książki"]);
    exit;
} elseif ($ksiazka['ilosc_dostepnych'] < $ilosc_pozyczona) {
    echo json_encode(["error" => "Brak wystarczającej liczby egzemplarzy"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO wypozyczenie (czytelnik_id, ksiazka_id) VALUES (?, ?)");
$stmt->bind_param("ii", $czytelnik_id, $ksiazka_id);

if ($stmt->execute()) {
    $stmt = $conn->prepare("UPDATE ksiazka SET ilosc_dostepnych = ilosc_dostepnych - ? WHERE id = ?");
    $stmt->bind_param("ii", $ilosc_pozyczona, $ksiazka_id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Wypożyczenie dodane pomyślnie"]);
} else {
    echo json_encode(["error" => "Nie udało się dodać wypożyczenia"]);
}
?>
