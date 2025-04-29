<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Lista autorów</h2>
      <table class="authors-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nazwisko</th>
            <th>Imię</th>
          </tr>
        </thead>
        <tbody>
          <!-- Відображення авторів -->
          <tr v-for="(author, index) in authors" :key="author.id">
            <td>{{ index + 1 }}</td>
            <td>{{ author.nazwisko }}</td>
            <td>{{ author.imie }}</td>
          </tr>
          <!-- Повідомлення про відсутність даних -->
          <tr v-if="authors.length === 0">
            <td colspan="3">Brak danych</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script>
import HeaderAdmin from '@/components/HeaderAdmin.vue'
import { ref, onMounted } from 'vue'

export default {
  components: { HeaderAdmin },
  setup() {
    const authors = ref([])

    onMounted(async () => {
      try {
        // Якщо ви налаштували проксі в Vite  
        const response = await fetch('http://localhost/wypozyczalniaVue/backend/api/authorAdmin.php'); 
        if (!response.ok) {
          throw new Error('Błąd serwera: ' + response.statusText);
        }
        const data = await response.json();
        authors.value = data.map(({ nazwisko, imie }) => ({ nazwisko, imie }));
      } catch (error) {
        console.error('Błąd przy pobieraniu autorów:', error);
        alert('Błąd przy pobieraniu autorów');
      }
    });

    return { authors };
  }
}
</script>

<style scoped>
/* Стилі */
</style>
