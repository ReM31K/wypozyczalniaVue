<template>
  <header>
    <div class="header-container">
      <img src="/images/logo.png" alt="Logo" class="logo" />
      <h1>Biblioteka</h1>
      <button @click="goToLogin">Log in</button>
    </div>
    <nav>
      <RouterLink to="/">Strona główna</RouterLink>
      <RouterLink to="/autorzy">Autorzy</RouterLink>
      <RouterLink to="/ksiazki">Książki</RouterLink>
      <RouterLink to="/wypozyczenia">Moje wypożyczenia</RouterLink>
    </nav>
  </header>
</template>

<script>
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    function goToLogin() {
      router.push('/login') // можна зробити окрему сторінку Login.vue
    }

    return { goToLogin }
  }
}
</script>

<style scoped>
/* Додай свої стилі або імпортуй з css */
</style>
