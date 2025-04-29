<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Lista czytelników</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Imię i Nazwisko</th>
            <th>Ulica</th>
            <th>Numer ulicy</th>
            <th>Numer mieszkania</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(reader, index) in readers" :key="reader.id">
            <td>{{ index + 1 }}</td>
            <td>{{ reader.pelne_imie }}</td>
            <td>{{ reader.ulica }}</td>
            <td>{{ reader.ulica_numer }}</td>
            <td>{{ reader.mieszkanie_numer }}</td>
            <td>{{ reader.email }}</td>
          </tr>
          <tr v-if="readers.length === 0">
            <td colspan="6">Brak danych</td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import HeaderAdmin from '@/components/HeaderAdmin.vue';

export default {
  components: { HeaderAdmin },
  setup() {
    const readers = ref([]);

    onMounted(async () => {
      try {
        const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/czytelnicyAdmin.php');
        if (!res.ok) throw new Error('Błąd przy pobieraniu czytelników');
        const data = await res.json();
        readers.value = data;
      } catch (err) {
        console.error(err);
        alert('Błąd przy pobieraniu czytelników');
      }
    });

    return { readers };
  }
};
</script>

<style scoped>
/* Сюди можна додати стилі для таблиці */
</style>
