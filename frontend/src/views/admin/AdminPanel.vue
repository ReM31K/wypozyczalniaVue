<template>
  <div>
    <HeaderAdmin />
    <main>
      <h2>Witamy w Panele Admin Biblioteki Online!</h2>

      <section class="info-section">
        <div class="info-box" v-for="(info, index) in adminSections" :key="index">
          <img :src="info.icon" :alt="info.alt" />
          <h3>{{ info.title }}</h3>
          <p>{{ info.description }}</p>
        </div>
      </section>
    </main>

    <footer>
      <p>© 2025. Wszelkie prawa zastrzeżone.</p>
    </footer>
  </div>
</template>

<script>
import HeaderAdmin from '@/components/HeaderAdmin.vue'

export default {
  components: {
    HeaderAdmin
  },
  data() {
    return {
      adminSections: [
        {
          icon: 'https://cdn-icons-png.flaticon.com/512/864/864685.png',
          alt: 'Book Icon',
          title: 'Kolekcja książek',
          description: 'Nasza biblioteka oferuje ponad 10 000 książek z różnych dziedzin — od literatury pięknej po naukę i technologię.'
        },
        {
          icon: 'https://cdn-icons-png.flaticon.com/512/1077/1077063.png',
          alt: 'Users Icon',
          title: 'Zarządzanie użytkownikami',
          description: 'Dodawaj, edytuj lub usuwaj konta użytkowników. Sprawdzaj ich historię wypożyczeń i aktualne rezerwacje.'
        },
        {
          icon: 'https://cdn-icons-png.flaticon.com/512/1250/1250615.png',
          alt: 'Pencil Icon',
          title: 'Zarządzanie książkami',
          description: 'Dodawaj nowe ksiązki i autorów. Bądź na bieżąco z aktualnymi ofertami dla wypożyczenia!'
        }
      ]
    }
  }
}
</script>

<style scoped>

</style>
