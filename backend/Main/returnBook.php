<?php
include 'baza.php';
session_start();
if (!isset($_SESSION['adminLog_id'])) {
    header("Location: /startBiblioteka.php"); // Якщо не адмін, перенаправляємо на головну
    exit();
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_POST['returnBook'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Nieprawidłowy token CSRF!");
    }

    $wypozyczenie_id = intval($_POST['wypozyczenie_id']);
    $ksiazka_id = intval($_POST['ksiazka_id']);

    $stmt = $conn->prepare("DELETE FROM wypozyczenie WHERE id = ?");
    $stmt->bind_param("i", $wypozyczenie_id);

    if ($stmt->execute()) {

        $updateStmt = $conn->prepare("UPDATE ksiazka SET ilosc_dostepnych = ilosc_dostepnych + 1 WHERE id = ?");
        $updateStmt->bind_param("i", $ksiazka_id);

        if ($updateStmt->execute()) {
            echo "<p>Książka została pomyślnie zwrócona, a ilość została zaktualizowana!</p>";
        } else {
            echo "<p>Błąd przy aktualizacji ilości książek: " . htmlspecialchars($conn->error) . "</p>";
        }
    } else {
        echo "<p>Błąd przy usuwaniu wypożyczenia: " . htmlspecialchars($conn->error) . "</p>";
    }
}


$readers = $conn->query("SELECT id, CONCAT(imie, ' ', nazwisko) AS pelne_imie FROM czytelnik ORDER BY nazwisko");
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Zwróć książkę</title>
</head>

<body>
    <header>

        <div class="header-container">
            <img src="../logo.png" alt="Logo" class="logo">
            <h1>Zwrot książki</h1>
            <?php
            if (isset($_SESSION['adminLog_id'])) {
                echo '<a href="logout.php" class="admin-logout-button">Wyloguj się</a>';
            }
            ?>
        </div>
        <?php include 'navigation.php'; ?>
    </header>
    <main>
        <h2>Wybierz czytelnika:</h2>
        <form method="GET">
            <label for="czytelnik_id">Wybierz czytelnika:</label>
            <select id="czytelnik_id" name="czytelnik_id" required>
                <option value="">-- Wybierz czytelnika --</option>
                <?php
                while ($reader = $readers->fetch_assoc()) {
                    $selected = isset($_GET['czytelnik_id']) && $_GET['czytelnik_id'] == $reader['id'] ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($reader['id']) . "' $selected>" . htmlspecialchars($reader['pelne_imie']) . "</option>";
                }
                ?>
            </select>
            <br>
            <button type="submit">Pokaż książki</button>
        </form>

        <?php
        if (isset($_GET['czytelnik_id'])) {
            $czytelnik_id = intval($_GET['czytelnik_id']);

            $stmt = $conn->prepare("SELECT wypozyczenie.id AS wypozyczenie_id, ksiazka.tytul, ksiazka.id AS ksiazka_id
                                    FROM wypozyczenie
                                    JOIN ksiazka ON wypozyczenie.ksiazka_id = ksiazka.id
                                    WHERE wypozyczenie.czytelnik_id = ?");
            $stmt->bind_param("i", $czytelnik_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<h2>Książki wypożyczone przez czytelnika:</h2>";
                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>#</th>
                            <th>Tytuł</th>
                            <th>Akcja</th>
                        </tr>
                      </thead>";
                echo "<tbody>";

                while ($wypozyczenie = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($wypozyczenie['wypozyczenie_id']) . "</td>
                            <td>" . htmlspecialchars($wypozyczenie['tytul']) . "</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='csrf_token' value='" . $_SESSION['csrf_token'] . "'>
                                    <input type='hidden' name='wypozyczenie_id' value='" . htmlspecialchars($wypozyczenie['wypozyczenie_id']) . "'>
                                    <input type='hidden' name='ksiazka_id' value='" . htmlspecialchars($wypozyczenie['ksiazka_id']) . "'>
                                    <button type='submit' name='returnBook'>Zwróć książkę</button>
                                </form>
                            </td>
                          </tr>";
                }

                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>Brak wypożyczonych książek.</p>";
            }
        }
        ?>
    </main>
    <footer>
        <p>© 2025 Wszelkie prawa zastrzeżone.</p>
    </footer>
</body>

</html>