<template>
  <div>
    <HeaderUser /> <!-- Навігація для користувача -->
    <main>
      <h2>Lista książek</h2>

      <!-- Список книг -->
      <table v-if="books.length > 0">
        <thead>
          <tr>
            <th>#</th>
            <th>Nazwa</th>
            <th>Autor</th>
            <th>Wydawca</th>
            <th>Tematy</th>
            <th>Rok publikacji</th>
            <th>Dostępne</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="book in books" :key="book.id">
            <td>{{ book.id }}</td>
            <td>{{ book.tytul }}</td>
            <td>{{ book.autor }}</td>
            <td>{{ book.wydawca }}</td>
            <td>{{ book.tematyka }}</td>
            <td>{{ book.rok_wydania }}</td>
            <td>{{ book.dostepnosc }}</td>
          </tr>
        </tbody>
      </table>
      
      <!-- Якщо немає даних -->
      <p v-else>Немає książek</p>
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
      books: [] // масив для зберігання книг
    }
  },
  mounted() {
    // Завантажуємо список книг при монтуванні компонента
    this.fetchBooks()
  },
  methods: {
    async fetchBooks() {
      try {
        const response = await axios.get('http://localhost/wypozyczalniaVue/backend/api/ksiazki.php');
        console.log(response.data); // Додаємо для перевірки відповіді
        this.books = response.data; // Зберігаємо дані у масив
      } catch (error) {
        console.error('Error fetching books:', error)
      }
    }
  }
}
</script>

<style scoped>
/* Стилі компонента */
</style>
