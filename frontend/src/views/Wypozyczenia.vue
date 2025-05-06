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

// Створення властивості для збереження стану автентифікації
const loggedIn = ref(false)

// ініціалізуємо масив wypozyczenia
const wypozyczenia = ref([])

const logout = async () => {
  try {
    // Відправка запиту на сервер для завершення сесії
    const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/logout.php', {
      method: 'POST',
      credentials: 'include', // Це дозволить передавати сесійні куки
    });

    // Перевірка відповіді сервера
    if (!res.ok) {
      throw new Error('Failed to logout');
    }

    // Якщо все добре, перенаправляємо на сторінку логіну
    router.push('/login');
  } catch (error) {
    console.error('Error logging out:', error);
  }
};

onMounted(async () => {
  try {
    const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/auth/check.php', {
      credentials: 'include'
    })

    if (!res.ok) {
      throw new Error('Failed to authenticate: ' + res.statusText)
    }

    const textData = await res.text()
    console.log('Auth response raw:', textData)

    const data = JSON.parse(textData)
    console.log('Auth response:', data)

    if (!data.authenticated) {
      loggedIn.value = false
      router.push('/login')
      return
    }

    loggedIn.value = true

    const booksRes = await fetch(`http://localhost/wypozyczalniaVue/backend/api/getWypozyczeniaByCzytelnik.php?czytelnik_id=${data.user_id}`, {
      credentials: 'include'
    })

    if (!booksRes.ok) {
      throw new Error('Failed to fetch books: ' + booksRes.statusText)
    }

    const booksText = await booksRes.text()
    console.log('Books response raw:', booksText)

    const booksData = JSON.parse(booksText)
    if (Array.isArray(booksData)) {
      wypozyczenia.value = booksData
    } else {
      console.error('Invalid response format:', booksData)
    }
  } catch (error) {
    console.error('Error checking auth or fetching books:', error)
    router.push('/login')
  }
})
</script>

<style scoped>
/* Ваші стилі тут */
</style>