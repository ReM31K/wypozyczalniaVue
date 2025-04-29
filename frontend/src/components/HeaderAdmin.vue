<template>
  <header>
    <div class="header-container">
      <div class="logo-container">
        <img src="/images/logo.png" alt="Logo" class="logo" />
        <h1>Panel Admina</h1>
      </div>
      <div class="button-container">
        <button @click="logout">Wyloguj się</button>
      </div>
    </div>
    <nav>
      <RouterLink to="/admin/dashboard">Panel główny</RouterLink>
      <RouterLink to="/admin/autorzy">Autorzy</RouterLink>
      <RouterLink to="/admin/ksiazki">Książki</RouterLink>
      <RouterLink to="/admin/czytelnicy">Czytelnicy</RouterLink>
      <RouterLink to="/admin/wypozyczenia">Wypozyczenia</RouterLink>
      <RouterLink to="/admin/addAutor">Dodać autora</RouterLink>
      <RouterLink to="/admin/addKsiazka">Dodać książkę</RouterLink>
      <RouterLink to="/admin/addWypozyczenie">Dodać wypożyczenie</RouterLink>
      <RouterLink to="/admin/returnBook">Usuń wypożyczenie</RouterLink>
    </nav>
  </header>
</template>

<script>
import { useRouter } from 'vue-router'

export default {
  setup() {
    const router = useRouter()

    function logout() {
      router.push('/start')
    }

    return { logout }
  }
}
</script>

<style scoped>
.header-container {
  display: flex;
  justify-content: space-between;
  align-items: center;          
  width: 100%;
  padding: 10px 20px;             
}

.logo-container {
  display: flex;
  align-items: center;           
  justify-content: center;        
  flex: 1;                       
}

.button-container {
  display: flex;
  justify-content: flex-end;
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
