<template>
  <div>
    <HeaderUser />  <!-- Навігація для користувача -->
    <main>
      <h2>Witamy w Bibliotece Online!</h2>
      <p>Nasza biblioteka to miejsce, gdzie każdy miłośnik literatury znajdzie coś dla siebie. Oferujemy bogaty wybór książek z różnych dziedzin – od klasycznych dzieł literatury po nowoczesne bestsellery. Dbamy o to, aby nasza kolekcja była różnorodna i dostępna dla wszystkich, niezależnie od zainteresowań. Zapraszamy do odkrywania świata książek i korzystania z zasobów naszej biblioteki!</p>

      <section class="books">
        <h3>Nasze popularne książki</h3>
        <div class="grid-container">
          <div class="book" v-for="book in books" :key="book.title">
            <img :src="book.image" :alt="book.title" />
            <p><strong>{{ book.title }}</strong> - {{ book.author }}</p>
          </div>
        </div>
      </section>

      <section class="authors">
        <h3>Nasi popularne autorzy</h3>
        <div class="grid-container">
          <div class="author" v-for="author in authors" :key="author.name">
            <img :src="author.image" :alt="author.name" />
            <p>{{ author.name }}</p>
          </div>
        </div>
      </section>
    </main>
    <Footer />
  </div>
</template>

<script>
import HeaderUser from '@/components/HeaderUser.vue'
import Footer from '@/components/Footer.vue'

export default {
  components: {
    HeaderUser,
    Footer
  },
  data() {
    return {
      books: [
        { title: 'Quo Vadis', author: 'Henryk Sienkiewicz', image: '/images/quo_vadis.jpg' },
        { title: 'Imperium', author: 'Ryszard Kapuściński', image: '/images/imperium.jpg' },
        { title: 'Pan Tadeusz', author: 'Adam Mickiewicz', image: '/images/pan_tadeusz.jpg' },
        { title: 'Lalka', author: 'Bolesław Prus', image: '/images/lalka.jpg' },
      ],
      authors: [
        { name: 'Henryk Sienkiewicz', image: '/images/sienkiewicz.jpg' },
        { name: 'Ryszard Kapuściński', image: '/images/kapuscinski.jpg' },
        { name: 'Adam Mickiewicz', image: '/images/mickiewicz.jpg' },
        { name: 'Bolesław Prus', image: '/images/prus.jpg' },
      ]
    }
  }
}
</script>

<style scoped>
/* Сюди або імпортуєш style.css */
</style>
