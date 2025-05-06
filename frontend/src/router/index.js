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
  { path: '/login', 'name': 'Login', component: Login },
  { path: '/register', component: Register },

  // Адмін маршрути
  { path: '/admin/panel', name: 'AdminPanel', component: AdminPanel, meta: { requiresAdmin: true } },
  { path: '/admin/start', name: 'AdminStart', component: AdminPanel, meta: { requiresAdmin: true } },

  { path: '/admin/autorzy', component: AdminAutorzy,
    meta: { requiresAdmin: true } },
  { path: '/admin/ksiazki', component: AdminKsiazki ,
    meta: { requiresAdmin: true }},
  { path: '/admin/czytelnicy', component: AdminCzytelnicy,
    meta: { requiresAdmin: true } },
  { path: '/admin/wypozyczenia', component: AdminWypozyczenia,
    meta: { requiresAdmin: true } },

  { path: '/admin/addAutor', component: AdminAddAutor,
    meta: { requiresAdmin: true } },
  { path: '/admin/addKsiazka', component: AdminAddKsiazka,
    meta: { requiresAdmin: true } },
  { path: '/admin/addWypozyczenie', component: AdminAddWypozyczenie,
    meta: { requiresAdmin: true } },
  { path: '/admin/returnBook', component: AdminReturnBook,
    meta: { requiresAdmin: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach(async (to, from, next) => {
  const res = await fetch('http://localhost/wypozyczalniaVue/backend/api/auth/check.php', {
    credentials: 'include'
  })

  const data = await res.json()

  if (to.meta.requiresAdmin) {
    if (data.authenticated && data.role === 'admin') {
      next()
    } else {
      next('/login')  // Якщо це не адмін, перенаправити на логін
    }
  } else {
    next()  // Якщо це не адмінський маршрут — проходимо далі
  }
})

export default router