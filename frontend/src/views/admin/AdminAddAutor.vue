<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Dodaj nowego autora</h2>
      <form @submit.prevent="dodajAutora">
        <label for="imie">Imię:</label>
        <input type="text" id="imie" v-model="autor.imie" required />
        <br />
        <label for="nazwisko">Nazwisko:</label>
        <input type="text" id="nazwisko" v-model="autor.nazwisko" required />
        <br />
        <button type="submit">Dodaj autora</button>
      </form>

      <p v-if="komunikat" :class="{ error: blad }">{{ komunikat }}</p>
    </main>
  </div>
</template>

<script>
import HeaderAdmin from '@/components/HeaderAdmin.vue'
import { ref } from 'vue'

export default {
  components: { HeaderAdmin },
  setup() {
    const autor = ref({ imie: '', nazwisko: '' })
    const komunikat = ref('')
    const blad = ref(false)

    const dodajAutora = async () => {
        try {
            const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/addAutor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(autor.value),
            });

            // Логування того, що відправляється
            console.log('Wysłane dane:', JSON.stringify(autor.value));

            if (!res.ok) {
            throw new Error('Failed to fetch: ' + res.status);
            }

            const data = await res.json();

            if (!res.ok) {
            komunikat.value = data.error || 'Nieznany błąd';
            blad.value = true;
            } else {
            komunikat.value = data.message;
            blad.value = false;
            autor.value = { imie: '', nazwisko: '' };
            }
        } catch (err) {
            komunikat.value = 'Błąd sieci lub serwera';
            blad.value = true;
            console.error('Błąd:', err);
        }
    };

    return { autor, dodajAutora, komunikat, blad }
  }
}
</script>

<style scoped>
.error {
  color: red;
  margin-top: 1em;
}
.admin-main {
  padding: 1em;
}
</style>
