<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Main/style.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Open+Sans:wght@400;600&family=Poppins:wght@400;600&display=swap"
    rel="stylesheet">
  <title>Biblioteka</title>
</head>

<body>
  <header>
    <div class="header-container">
      <img src="logo.png" alt="Logo" class="logo">
      <h1>Moje Konto</h1>
    </div>

    <!-- Контейнер для посилань на логін, реєстрацію та профіль -->
    <div class="auth-container">
      <?php
      session_start();
      if (isset($_SESSION['user_id'])) {
        // Якщо користувач залогінений, показуємо посилання на профіль
        echo '<a href="/User/logout.php" class="profile-link">Logout</a>';
      } else {
        // Якщо користувач не залогінений, показуємо посилання на логін та реєстрацію
        echo '<a href="User/loginUser.php" class="auth-link">Logowanie</a> | <a href="User/registerUser.php" class="auth-link">Rejestracja</a>';
      }
      ?>

      <!-- Кнопка для логіну адміністратора -->
    </div>

    <nav>
      <a href="startBiblioteka.php">Strona główna</a>
      <a href="User/autorzy.php">Autorzy</a>
      <a href="User/ksiazki.php">Książki</a>
      <a href="User/wypozyczenia.php">Moje wypożyczenia</a>
    </nav>
  </header>
  <main>
    <h2>Witamy w Bibliotece Online!</h2>
    <p>Nasza biblioteka to miejsce, gdzie każdy miłośnik literatury znajdzie coś dla siebie. Oferujemy bogaty wybór książek z
      różnych dziedzin – od klasycznych dzieł literatury po nowoczesne bestsellery. Dbamy o to, aby nasza kolekcja była
      różnorodna i dostępna dla wszystkich, niezależnie od zainteresowań. Zapraszamy do odkrywania świata książek i
      korzystania z zasobów naszej biblioteki!</p>

    <section class="books">
      <h3>Nasze książki</h3>
      <div class="grid-container">
        <div class="book">
          <img src="images/quo_vadis.jpg" alt="Quo Vadis">
          <p><strong>Quo Vadis</strong> - Henryk Sienkiewicz</p>
        </div>
        <div class="book">
          <img src="images/imperium.jpg" alt="Imperium">
          <p><strong>Imperium</strong> - Ryszard Kapuściński</p>
        </div>
        <div class="book">
          <img src="images/pan_tadeusz.jpg" alt="Pan Tadeusz">
          <p><strong>Pan Tadeusz</strong> - Adam Mickiewicz</p>
        </div>
        <div class="book">
          <img src="images/lalka.jpg" alt="Lalka">
          <p><strong>Lalka</strong> - Bolesław Prus</p>
        </div>
      </div>
    </section>

    <section class="authors">
      <h3>Nasi autorzy</h3>
      <div class="grid-container">
        <div class="author">
          <img src="images/sienkiewicz.jpg" alt="Henryk Sienkiewicz">
          <p>Henryk Sienkiewicz</p>
        </div>
        <div class="author">
          <img src="images/kapuscinski.jpg" alt="Ryszard Kapuściński">
          <p>Ryszard Kapuściński</p>
        </div>
        <div class="author">
          <img src="images/mickiewicz.jpg" alt="Adam Mickiewicz">
          <p>Adam Mickiewicz</p>
        </div>
        <div class="author">
          <img src="images/prus.jpg" alt="Bolesław Prus">
          <p>Bolesław Prus</p>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2025. Wszelkie prawa zastrzeżone.</p>
  </footer>
</body>

</html>