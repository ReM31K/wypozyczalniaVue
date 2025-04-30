import { createRouter, createWebHistory } from 'vue-router'

import StartPage from '../views/StartPage.vue'
import Autorzy from '../views/Autorzy.vue'
import Ksiazki from '../views/Ksiazki.vue'
import Wypozyczenia from '../views/Wypozyczenia.vue'
import Login from '../views/LoginUser.vue'
import Register from '../views/RegisterUser.vue'

// Для адміна
import AdminPanel from '../views/admin/AdminPanel.vue'
import AdminAutorzy from '../views/admin/AdminAutorzy.vue'
import AdminKsiazki from '../views/admin/AdminKsiazki.vue'
import AdminCzytelnicy from '../views/admin/AdminCzytelnicy.vue'
import AdminWypozyczenia from '../views/admin/AdminWypozyczenia.vue'

import AdminAddAutor from '../views/admin/AdminAddAutor.vue'
import AdminAddKsiazka from '../views/admin/AdminAddKsiazka.vue'
import AdminAddWypozyczenie from '../views/admin/AdminAddWypozyczenie.vue'
import AdminReturnBook from '../views/admin/AdminReturnBook.vue'

const routes = [
  { path: '/', component: StartPage },
  { path: '/autorzy', component: Autorzy },
  { path: '/ksiazki', component: Ksiazki },
  { path: '/wypozyczenia', component: Wypozyczenia },
  { path: '/login', component: Login },
  { path: '/register', component: Register },

  // Адмін маршрути
  { path: '/admin/dashboard', component: AdminPanel },
  { path: '/admin/autorzy', component: AdminAutorzy },
  { path: '/admin/ksiazki', component: AdminKsiazki },
  { path: '/admin/czytelnicy', component: AdminCzytelnicy },
  { path: '/admin/wypozyczenia', component: AdminWypozyczenia },

  { path: '/admin/addAutor', component: AdminAddAutor },
  { path: '/admin/addKsiazka', component: AdminAddKsiazka },
  { path: '/admin/addWypozyczenie', component: AdminAddWypozyczenie },
  { path: '/admin/returnBook', component: AdminReturnBook },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
