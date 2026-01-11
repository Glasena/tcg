import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CardListView from '@/views/cards/CardListView.vue'
import CardFormView from '@/views/cards/CardFormView.vue'
import RegisterView from '@/views/RegisterView.vue'

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
  ],
})

export default router
