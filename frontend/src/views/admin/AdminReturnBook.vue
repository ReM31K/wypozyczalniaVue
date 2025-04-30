<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Zwrot książki</h2>

      <form @submit.prevent="fetchWypozyczenia">
        <label for="czytelnik_id">Wybierz czytelnika:</label>
        <select v-model="czytelnikId" required>
          <option value="">-- Wybierz czytelnika --</option>
          <option v-for="czytelnik in czytelnicy" :key="czytelnik.id" :value="czytelnik.id">
            {{ czytelnik.pelne_imie }}
          </option>
        </select>
        <br />
        <button type="submit">Pokaż książki</button>
      </form>

      <div v-if="wypozyczenia.length">
        <h3>Książki wypożyczone:</h3>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Tytuł</th>
              <th>Akcja</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="w in wypozyczenia" :key="w.wypozyczenie_id">
              <td>{{ w.wypozyczenie_id }}</td>
              <td>{{ w.tytul }}</td>
              <td>
                <button @click="zwracajKsiazke(w.wypozyczenie_id, w.ksiazka_id)">Zwróć</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <p v-if="message" :class="{ error: error, success: !error }">{{ message }}</p>
    </main>
  </div>
</template>

<script>
import HeaderAdmin from "@/components/HeaderAdmin.vue";

export default {
  components: { HeaderAdmin },
  data() {
    return {
      czytelnicy: [],
      wypozyczenia: [],
      czytelnikId: "",
      message: "",
      error: false,
    };
  },
  mounted() {
    this.fetchCzytelnicy();
  },
  methods: {
    async fetchCzytelnicy() {
      const res = await fetch("http://localhost/wypozyczalniaVue/backend/api/getCzytelnicy.php");
      this.czytelnicy = await res.json();
    },
    async fetchWypozyczenia() {
      this.wypozyczenia = [];
      this.message = "";
      if (!this.czytelnikId) return;

      const res = await fetch(`http://localhost/wypozyczalniaVue/backend/api/getWypozyczeniaByCzytelnik.php?czytelnik_id=${this.czytelnikId}`);
      this.wypozyczenia = await res.json();
    },
    async zwracajKsiazke(wypozyczenie_id, ksiazka_id) {
      const res = await fetch("http://localhost/wypozyczalniaVue/backend/api/returnBook.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ wypozyczenie_id, ksiazka_id })
      });

      const data = await res.json();

      if (data.success) {
        this.message = data.message;
        this.error = false;
        this.fetchWypozyczenia();
      } else {
        this.message = data.error || "Błąd przy zwrocie książki";
        this.error = true;
      }
    }
  }
};
</script>

<style scoped>
.admin-main {
  padding: 2rem;
  max-width: 900px;
  margin: 0 auto;
  text-align: left;
}

select {
  padding: 0.5rem;
  width: 100%;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-family: inherit;
  font-size: 1rem;
}

button{
  width: 100%;
    padding: 12px;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #21618c;
}

.success {
  color: #3cb371;
  margin-top: 1rem;
  font-weight: 500;
}

.error {
  color: #e74c3c;
  margin-top: 1rem;
  font-weight: 500;
}

</style>
