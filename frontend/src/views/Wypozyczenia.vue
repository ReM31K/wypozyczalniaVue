<template>
  <div class="wypozyczenia-page">
    <header class="header-container">
      <img src="/images/logo.png" alt="Logo" class="logo" />
      <h1>Wypożyczenia</h1>
      <div class="auth-container">
        <button v-if="loggedIn" @click="logout">Logout</button>
        <div v-else>
          <RouterLink to="/login">Log in</RouterLink> |
          <RouterLink to="/register">Reg in</RouterLink>
        </div>
      </div>
    </header>

    <main>
      <h2>Twoje wypożyczone książki</h2>
      <!-- Перевірка на наявність елементів у масиві wypozyczenia -->
      <table v-if="wypozyczenia && wypozyczenia.length > 0">
        <thead>
          <tr>
            <th>Tytuł książki</th>
            <th>Rok wydania</th>
            <th>Autor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(ksiazka, index) in wypozyczenia" :key="index">
            <td>{{ ksiazka.tytul }}</td>
            <td>{{ ksiazka.rok_wydania }}</td>
            <td>{{ ksiazka.autor }}</td>
          </tr>
        </tbody>
      </table>
      <p v-else>Nie wypożyczyłeś żadnej książki.</p>
    </main>

    <footer>
      <p>© 2025 Wszelkie prawa zastrzeżone.</p>
    </footer>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// ініціалізуємо масив wypozyczenia
const wypozyczenia = ref([])

onMounted(async () => {
  try {
    const res = await fetch('/api/auth/check.php', {
      credentials: 'include' // обов’язково для сесії
    })
    const data = await res.json()

    if (!data.authenticated) {
      router.push('/login') // Якщо не авторизовано, перенаправляємо на логін
      return
    }

    // Якщо користувач авторизований, отримуємо дані про книги
    const booksRes = await fetch('/api/books/getWypozyczenia.php', {
      credentials: 'include' // обов’язково для сесії
    })
    const booksData = await booksRes.json()

    // Перевіряємо наявність даних
    if (Array.isArray(booksData)) {
      wypozyczenia.value = booksData // Якщо дані отримано, зберігаємо їх в масив
    } else {
      console.error('Invalid response format:', booksData)
    }
  } catch (error) {
    console.error('Error checking auth or fetching books:', error)
    router.push('/login') // У разі помилки також перенаправляємо на логін
  }
})
</script>

<style scoped>
/* Ваші стилі тут */
</style>
