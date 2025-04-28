<template>
  <header>
    <div class="header-container">
      <img src="/images/logo.png" alt="Logo" class="logo" />
      <h1>Panel Admina</h1>
      <button @click="logout">Wyloguj się</button>
    </div>
    <nav>
      <RouterLink to="/admin/dashboard">Panel główny</RouterLink>
      <RouterLink to="/admin/autorzy">Autorzy</RouterLink>
      <RouterLink to="/admin/ksiazki">Książki</RouterLink>
      <RouterLink to="/admin/uzytkownicy">Użytkownicy</RouterLink>
    </nav>
  </header>
</template>

<script>
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    function logout() {
      // Реалізуєш в майбутньому через бекенд
      router.push('/login')
    }

    return { logout }
  }
}
</script>

<style scoped>
/* Тут свої стилі */
</style>
