import { createRouter, createWebHistory } from 'vue-router'
import VitrineLayout from '@/layouts/VitrineLayout.vue'
import HomeView from '@/features/vitrine/views/HomeView.vue'
import LoginView from '@/features/auth/views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '',
      component: VitrineLayout,
      children: [
        { path: '', name: 'home', component: HomeView },
        { path: '/se-connecter', name: 'login', component: LoginView }
      ],
    },
  ],
  // Liens d'ancre (#tarifs, #faq…) : défilement doux vers la section.
  // Le décalage sous le header sticky est géré en CSS (scroll-mt-20).
  scrollBehavior(to, _from, savedPosition) {
    if (savedPosition) return savedPosition
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0 }
  },
})

export default router