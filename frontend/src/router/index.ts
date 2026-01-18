import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CardListView from '@/views/cards/CardListView.vue'
import CardFormView from '@/views/cards/CardFormView.vue'
import RegisterView from '@/views/auth/RegisterView.vue'
import LoginView from '@/views/auth/LoginView.vue'
import CardShowView from '@/views/cards/CardShowView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/cards',
      name: 'cards.index',
      component: CardListView,
    },
    {
      path: '/cards/create',
      name: 'cards.create',
      component: CardFormView,
    },
    {
      path: '/cards/:id/edit',
      name: 'cards.edit',
      component: CardFormView,
    },
    {
      path: '/cards/:id',
      name: 'CardShow',
      component: CardShowView,
    },
  ],
})

export default router
