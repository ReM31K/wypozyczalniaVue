<template>
  <div>
    <HeaderAdmin />
    <main class="admin-main">
      <h2>Dodaj nową książkę</h2>
      <form @submit.prevent="dodajKsiazke">
        <label for="tytul">Tytuł:</label>
        <input type="text" id="tytul" v-model="ksiazka.tytul" required />
        <br />

        <label for="autor_id">Autor:</label>
        <select id="autor_id" v-model="ksiazka.autor_id" required>
          <option value="">Wybierz autora</option>
          <option v-for="author in authors" :key="author.id" :value="author.id">
            {{ author.pelne_imie }}
          </option>
        </select>
        <br />

        <label for="wydawca">Wydawnictwo:</label>
        <input type="text" id="wydawca" v-model="ksiazka.wydawca" required />
        <br />

        <label for="tematyka">Tematyka:</label>
        <input type="text" id="tematyka" v-model="ksiazka.tematyka" required />
        <br />

        <label for="rok_wydania">Rok wydania:</label>
        <input type="number" id="rok_wydania" v-model="ksiazka.rok_wydania" required />
        <br />

        <label for="ilosc_calkowita">Ilość całkowita:</label>
        <input type="number" id="ilosc_calkowita" v-model="ksiazka.ilosc_calkowita" required />
        <br />

        <button type="submit">Dodaj książkę</button>
      </form>

      <!-- Додав комунікат помилки або успіху -->
      <p v-if="komunikat" :class="{ error: blad }">{{ komunikat }}</p>
    </main>
  </div>
</template>

<script>
import HeaderAdmin from "@/components/HeaderAdmin.vue";
import { ref, onMounted } from "vue";

export default {
  components: { HeaderAdmin },
  setup() {
    const ksiazka = ref({
      tytul: "",
      autor_id: "",
      wydawca: "",
      tematyka: "",
      rok_wydania: "",
      ilosc_calkowita: "",
    });
    const authors = ref([]);
    const komunikat = ref("");
    const blad = ref(false);

    // Завантаження списку авторів з API
    const fetchAuthors = async () => {
      try {
        const response = await fetch("http://localhost/wypozyczalniaVue/backend/api/getAuthors.php");
        const data = await response.json();

        console.log("Дані авторів:", data);  // Лог для перевірки

        if (data.error) {
          console.error(data.error);
          komunikat.value = "Błąd przy ładowaniu autorów.";
          blad.value = true;
        } else {
          authors.value = data;
        }
      } catch (err) {
        console.error("Błąd podczas ładowania autorów:", err);
        komunikat.value = "Błąd przy ładowaniu autorów.";
        blad.value = true;
      }
    };

    // Відправка форми додавання книги
    const dodajKsiazke = async () => {
      try {
        const response = await fetch("http://localhost/wypozyczalniaVue/backend/api/addKsiazka.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(ksiazka.value),
        });

        const data = await response.json();

        if (response.ok) {
          komunikat.value = data.message;
          blad.value = false;
          // Очистити форму після успішного додавання
          ksiazka.value = {
            tytul: "",
            autor_id: "",
            wydawca: "",
            tematyka: "",
            rok_wydania: "",
            ilosc_calkowita: "",
          };
        } else {
          komunikat.value = data.error || "Nieznany błąd";
          blad.value = true;
        }
      } catch (err) {
        komunikat.value = "Błąd sieci lub serwera";
        blad.value = true;
        console.error(err);
      }
    };

    // Завантаження авторів після монтування компонента
    onMounted(fetchAuthors);

    return { ksiazka, authors, dodajKsiazke, komunikat, blad };
  },
};
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
