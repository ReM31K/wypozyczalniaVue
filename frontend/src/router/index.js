import { createRouter, createWebHistory } from 'vue-router'

// Імпортуємо компоненти
import StartPage from '../views/StartPage.vue'
import Autorzy from '../views/Autorzy.vue'
import Ksiazki from '../views/Ksiazki.vue'
/*import Wypozyczenia from '../views/Wypozyczenia.vue'
import Login from '../views/Login.vue'

// Для адміна
import AdminDashboard from '../views/admin/AdminDashboard.vue'
import AdminAutorzy from '../views/admin/AdminAutorzy.vue'
import AdminKsiazki from '../views/admin/AdminKsiazki.vue'
import AdminUzytkownicy from '../views/admin/AdminUzytkownicy.vue'*/

const routes = [
  { path: '/', component: StartPage },
  { path: '/autorzy', component: Autorzy },
  { path: '/ksiazki', component: Ksiazki },
  /*{ path: '/wypozyczenia', component: Wypozyczenia },
  { path: '/login', component: Login },

  // Адмін маршрути
  { path: '/admin/dashboard', component: AdminDashboard },
  { path: '/admin/autorzy', component: AdminAutorzy },
  { path: '/admin/ksiazki', component: AdminKsiazki },
  { path: '/admin/uzytkownicy', component: AdminUzytkownicy },*/
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
