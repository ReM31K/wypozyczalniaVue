<template>
  <div>
    <HeaderUser /> <!-- Навігація для користувача -->
    <main>
      <h2>Lista autorów</h2>

      <!-- Список авторів -->
      <table v-if="authors.length > 0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nazwisko</th>
            <th>Imię</th>
            <th>Tytuł</th>
            <th>Rok wydania</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="author in authors" :key="author.id">
            <td>{{ author.id }}</td>
            <td>{{ author.nazwisko }}</td>
            <td>{{ author.imie }}</td>
            <td>{{ author.tytul || 'Brak książki' }}</td>
            <td>{{ author.rok_wydania || '-' }}</td>
          </tr>
        </tbody>
      </table>
      
      <!-- Якщо немає даних -->
      <p v-else>Немає записів</p>
    </main>
    <Footer /> <!-- Футер -->
  </div>
</template>

<script>
import HeaderUser from '@/components/HeaderUser.vue'
import Footer from '@/components/Footer.vue'
import axios from 'axios'

export default {
  components: {
    HeaderUser,
    Footer
  },
  data() {
    return {
      authors: [] // масив для зберігання авторів
    }
  },
  mounted() {
    // Завантажуємо список авторів при монтуванні компонента
    this.fetchAuthors()
  },
  methods: {
    async fetchAuthors() {
      try {
        // Виконання GET запиту до PHP API
        const response = await axios.get('http://localhost/wypozyczalniaVue/backend/api/authors.php')
        console.log(response); // Логування відповіді
        this.authors = response.data; // Зберігаємо дані у масив
      } catch (error) {
        console.error('Error fetching authors:', error)
      }
    }
  }
}
</script>

<style scoped>
/* Стилі компонента */
</style>
