<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Dodaj nowe wypożyczenie</h2>

      <form @submit.prevent="dodajWypozyczenie">
        <label for="czytelnik_id">Czytelnik:</label>
        <select id="czytelnik_id" v-model="form.czytelnik_id" required>
          <option disabled value="">-- Wybierz czytelnika --</option>
          <option v-for="czytelnik in czytelnicy" :key="czytelnik.id" :value="czytelnik.id">
            {{ czytelnik.pelne_imie }}
          </option>
        </select>
        <br />

        <label for="ksiazka_id">Książka:</label>
        <select id="ksiazka_id" v-model="form.ksiazka_id" required>
          <option disabled value="">-- Wybierz książkę --</option>
          <option v-for="ksiazka in ksiazki" :key="ksiazka.id" :value="ksiazka.id">
            {{ ksiazka.tytul }}
          </option>
        </select>
        <br />

        <label for="ilosc">Ilość:</label>
        <input type="number" id="ilosc" v-model="form.ilosc" min="1" required />
        <br />

        <button type="submit">Dodaj wypożyczenie</button>
      </form>

      <p v-if="message && !error" class="success">{{ message }}</p>
      <p v-if="error" class="error">{{ error }}</p>
    </main>
  </div>
</template>

<script>
import HeaderAdmin from "@/components/HeaderAdmin.vue";

export default {
  components: { HeaderAdmin },
  data() {
    return {
      form: {
        czytelnik_id: "",
        ksiazka_id: "",
        ilosc: 1,
      },
      czytelnicy: [],
      ksiazki: [],
      message: "",
      error: "",
    };
  },
  mounted() {
    this.fetchCzytelnicy();
    this.fetchKsiazki();
  },
  methods: {
    async fetchCzytelnicy() {
      const res = await fetch("http://localhost/wypozyczalniaVue/backend/api/getCzytelnicy.php");
      this.czytelnicy = await res.json();
    },
    async fetchKsiazki() {
      const res = await fetch("http://localhost/wypozyczalniaVue/backend/api/getKsiazki.php");
      this.ksiazki = await res.json();
    },
    async dodajWypozyczenie() {
      this.message = "";
      this.error = "";

      const res = await fetch("http://localhost/wypozyczalniaVue/backend/api/addWypozyczenie.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(this.form),
      });

      const data = await res.json();
      if (data.success) {
        this.message = data.message;
        this.form = { czytelnik_id: "", ksiazka_id: "", ilosc: 1 };
      } else {
        this.error = data.error || "Błąd dodawania";
      }
    },
  },
};
</script>

<style scoped>
.admin-main {
  padding: 1em;
}
label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}
input,
select {
  width: 100%;
  padding: 6px;
  margin-top: 4px;
}
button {
  margin-top: 15px;
  padding: 8px 16px;
  background-color: #007acc;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #005fa3;
}
.success {
  color: green;
  margin-top: 1em;
}
.error {
  color: red;
  margin-top: 1em;
}
</style>
