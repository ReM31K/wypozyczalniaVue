<template> 
  <div>
    <HeaderUser />
    <main>
      <img src="/images/logowanie.jpg" id="logowanieImage" alt="Rejestracja" />

      <form class="container" @submit.prevent="handleRegister">
        <h1 class="login-title">Rejestracja</h1>

        <p v-if="error" class="error-message">{{ error }}</p>
        <p v-if="success" class="success-message">{{ success }}</p>

        <section class="input-box"><input type="text" v-model="imie" placeholder="Imię" required /></section>
        <section class="input-box"><input type="text" v-model="nazwisko" placeholder="Nazwisko" required /></section>
        <section class="input-box"><input type="email" v-model="email" placeholder="Email" required /></section>
        <section class="input-box"><input type="password" v-model="haslo" placeholder="Hasło" required /></section>
        <section class="input-box"><input type="text" v-model="ulica" placeholder="Ulica" required /></section>
        <section class="input-box"><input type="text" v-model="ulicaNumer" placeholder="Numer ulicy" required /></section>
        <section class="input-box"><input type="text" v-model="mieszkanieNumer" placeholder="Numer mieszkania" /></section>

        <button class="login-button" type="submit">Zarejestruj się</button>

        <div class="small-buttons">
          <router-link to="/" class="small-btn">Strona główna</router-link>
          <router-link to="/login" class="small-btn">Logowanie</router-link>
        </div>
      </form>
    </main>
    <Footer />
  </div>
</template>

<script>
import axios from 'axios';
import HeaderUser from '@/components/HeaderUser.vue';
import Footer from '@/components/Footer.vue';

export default {
  components: { HeaderUser, Footer },
  data() {
    return {
      imie: '',
      nazwisko: '',
      email: '',
      haslo: '',
      ulica: '',
      ulicaNumer: '',
      mieszkanieNumer: '',
      error: '',
      success: ''
    }
  },
  methods: {
    async handleRegister() {
      this.error = '';
      this.success = '';

      try {
        const formData = new FormData();
        formData.append('imie', this.imie);
        formData.append('nazwisko', this.nazwisko);
        formData.append('email', this.email);
        formData.append('haslo', this.haslo);
        formData.append('ulica_nazwa', this.ulica);
        formData.append('ulica_numer', this.ulicaNumer);
        formData.append('mieszkanie_numer', this.mieszkanieNumer);

        const response = await axios.post(
          'http://localhost/wypozyczalniaVue/backend/api/registerUser.php',
          formData
        );

        if (response.data.status === 'success') {
          this.success = response.data.message;
          this.clearForm();
          setTimeout(() => {
            this.$router.push('/login');
          }, 1500);
        } else {
          this.error = response.data.message || 'Помилка реєстрації.';
        }
      } catch (err) {
        this.error = 'Помилка з\'єднання з сервером.';
        console.error(err);
      }
    },

    clearForm() {
      this.imie = '';
      this.nazwisko = '';
      this.email = '';
      this.haslo = '';
      this.ulica = '';
      this.ulicaNumer = '';
      this.mieszkanieNumer = '';
    }
  }
};
</script>

<style scoped>
#logowanieImage {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  object-fit: cover;
}

.small-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 1.5rem;
}

.small-btn {
  font-weight: 500;
  color: #646cff;
  text-decoration: inherit;
  transition: color 0.25s;
}

.small-btn:hover {
  color: #535bf2;
}
</style>
