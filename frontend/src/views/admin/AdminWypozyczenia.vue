<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Lista wypożyczeń</h2>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Czytelnik</th>
            <th>Książka</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(w, index) in wypozyczenia" :key="w.id">
            <td>{{ index + 1 }}</td>
            <td>{{ w.pelne_imie }}</td>
            <td>{{ w.ksiazka }}</td>
          </tr>
          <tr v-if="wypozyczenia.length === 0">
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
    const wypozyczenia = ref([])

    onMounted(async () => {
      try {
        const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/wypozyczeniaAdmin.php')
        if (!res.ok) {
          if (res.status === 403) {
            alert('Brak dostępu (403)');
          } else {
            throw new Error('Błąd serwera');
          }
        }
        const data = await res.json()
        wypozyczenia.value = data
      } catch (error) {
        console.error('Błąd przy pobieraniu wypożyczeń:', error)
        alert('Błąd przy pobieraniu danych')
      }
    })

    return { wypozyczenia }
  }
}
</script>

<style scoped>
/* Możна додати стилі таблиці */
</style>
