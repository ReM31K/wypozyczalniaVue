<template>
  <div class="wypozyczenia-page">
    <HeaderUserWypozyczenie :onLogout="logout" />
    <main>
      <h2>Twoje wypożyczone książki</h2>
      <table v-if="wypozyczenia && wypozyczenia.length > 0">
        <thead>
          <tr>
            <th>Tytuł książki</th>
            <th>Rok wydania</th>
            <th>Autor</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(ksiazka, index) in wypozyczenia" :key="index">
            <td>{{ ksiazka.tytul }}</td>
            <td>{{ ksiazka.rok_wydania }}</td>
            <td>{{ ksiazka.autor }}</td>
          </tr>
        </tbody>
      </table>
      <p v-else>Nie wypożyczyłeś żadnej książki.</p>
    </main>

    <Footer />
  </div>
</template>

<script setup>
import HeaderUserWypozyczenie from '@/components/HeaderUserWypozyczenie.vue'
import Footer from '@/components/Footer.vue'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loggedIn = ref(false)
const wypozyczenia = ref([])

const logout = async () => {
  try {
    const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/logout.php', {
      method: 'POST',
      credentials: 'include',
    })

    if (!res.ok) {
      throw new Error('Failed to logout')
    }

    loggedIn.value = false
    router.push('/login')
  } catch (error) {
    console.error('Error logging out:', error)
  }
}

onMounted(async () => {
  try {
    const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/auth/check.php', {
      credentials: 'include'
    })

    if (!res.ok) throw new Error('Failed to authenticate')

    const data = await res.json()

    if (!data.authenticated) {
      loggedIn.value = false
      router.push('/login')
      return
    }

    loggedIn.value = true

    const booksRes = await fetch(
      `http://localhost/wypozyczalniaVue/backend/api/getWypozyczeniaByCzytelnik.php?czytelnik_id=${data.user_id}`,
      { credentials: 'include' }
    )

    const booksData = await booksRes.json()
    wypozyczenia.value = Array.isArray(booksData) ? booksData : []
  } catch (error) {
    console.error('Error:', error)
    router.push('/login')
  }
})
</script>

<style scoped>
/* Стилі можна додати тут */
</style>
