<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Lista książek</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nazwa</th>
            <th>Autor</th>
            <th>Wydawca</th>
            <th>Tematy</th>
            <th>Rok publikacji</th>
            <th>Ilość całkowita</th>
            <th>Dostępna ilość</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(book, index) in books" :key="book.id">
            <td>{{ index + 1 }}</td>
            <td>{{ book.tytul }}</td>
            <td>{{ book.autor }}</td>
            <td>{{ book.wydawca }}</td>
            <td>{{ book.tematyka }}</td>
            <td>{{ book.rok_wydania }}</td>
            <td>{{ book.ilosc_calkowita }}</td>
            <td>{{ book.ilosc_dostepnych }}</td>
          </tr>
          <tr v-if="books.length === 0">
            <td colspan="8">Немає записів</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import HeaderAdmin from '@/components/HeaderAdmin.vue';
import { useRouter } from 'vue-router';

export default {
  components: {
    HeaderAdmin
  },
  setup() {
    const books = ref([]);
    const router = useRouter();

    onMounted(async () => {

      try {
        const response = await fetch('http://localhost/wypozyczalniaVue/backend/api/ksiazkiAdmin.php');
        if (!response.ok) {
          throw new Error('Błąd serwera: ' + response.statusText);
        }
        const data = await response.json();
        console.log('Fetched data:', data);

        books.value = data.map(book => ({
          id: book.id,
          tytul: book.tytul,
          autor: book.autor,
          wydawca: book.wydawca,
          tematyka: book.tematyka,
          rok_wydania: book.rok_wydania,
          ilosc_calkowita: book.ilosc_calkowita,
          ilosc_dostepnych: book.ilosc_dostepnych,
        }));

        console.log('Mapped books:', books.value);
      } catch (error) {
        console.error('Błąd przy pobieraniu książek:', error);
        alert('Błąd przy pobieraniu książek');
      }
    });

    return { books };
  }
};
</script>

<style scoped>

</style>
