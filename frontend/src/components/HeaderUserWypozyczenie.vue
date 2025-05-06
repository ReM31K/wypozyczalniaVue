<template>
  <header>
    <div class="header-container">
      <div class="button-container">
        <button @click="onLogout">Logout</button>
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

<script setup>
defineProps({
  onLogout: {
    type: Function,
    required: true
  }
})
</script>

<style scoped>
.header-container {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80px;
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
  padding-right: 20px;
  width: 100%;
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
