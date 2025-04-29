<template>
  <header>
    <div class="header-container">
      <div class="button-container">
        <button @click="goToLogin">Log in</button>
        <button @click="goToRegister">Reg in</button>
      </div>

      <div class="logo-container">
        <img src="/images/logo.png" alt="Logo" class="logo" />
        <h1>Biblioteka</h1>
      </div>
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
      router.push('/login') 
    }

    function goToRegister() {
      router.push('/register') 
    }

    return { goToLogin, goToRegister }
  }
}
</script>

<style scoped>
.header-container {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80px; /* або свій розмір */
}

.logo-container {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
}

.button-container {
  margin-left: auto;
  display: flex;
  gap: 10px;
  padding-right: 20px; /* невеликий відступ справа */
}

.button-container {
  display: flex;
  justify-content: flex-end;
  gap: 10px; /* відстань між кнопками */
  width: 100%;
}

button {
  padding: 8px 16px;
  background-color: #2980b9;
  color: white;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s;
}
</style>
