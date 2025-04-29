<template>
  <div>
    <HeaderGuest />
    <main>
      <img src="/images/logowanie.jpg" id="logowanieImage" alt="Login image" />

      <form class="container" @submit.prevent="handleLogin">
        <h1 class="login-title">Login</h1>

        <p v-if="error" class="error-message">{{ error }}</p>

        <section class="input-box">
          <input type="email" v-model="email" placeholder="Email" required />
        </section>

        <section class="input-box">
          <input type="password" v-model="password" placeholder="Hasło" required />
        </section>

        <button class="login-button" type="submit">Zaloguj się</button>

        <div class="small-buttons">
          <router-link to="/" class="small-btn">Home</router-link>
          <router-link to="/register" class="small-btn">Register</router-link>
        </div>
      </form>
    </main>
    <Footer />
  </div>
</template>

<script>
import axios from 'axios'
import HeaderUser from '@/components/HeaderUser.vue'
import Footer from '@/components/Footer.vue'

export default {
  components: {
    HeaderUser,
    Footer
  },
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },
  methods: {
    async handleLogin() {
      console.log("Email: ", this.email);
      console.log("Password: ", this.password);

      try {
        const response = await axios.get(
          'http://localhost/wypozyczalniaVue/backend/api/test_log.php',
          {
            email: this.email,
            haslo: this.password
          },
          {
            withCredentials: true,
            headers: {
              'Content-Type': 'application/json'
            }
          }
        );

        if (response.data.status === 'success') {
          if (response.data.role === 'user') {
            this.$router.push('/wypozyczenia');
          } else if (response.data.role === 'admin') {
            this.$router.push('/admin');
          }
        } else {
          this.error = response.data.message || 'Błąd logowania.';
        }
      } catch (err) {
        this.error = 'Wystąpił błąd serwera.';
        console.error('Login error:', err.response ? err.response.data : err.message);
      }
    }
  }
}

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
