// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    redirect: '/home',
  },
  {
    path: '/home',
    component: () => import('@/layouts/home/Home.vue'),
  },
  {
    path: '/search',
    component: () => import('@/layouts/search/Search.vue'),
  },
  {
    path: '/notifications',
    component: () => import('@/layouts/notifications/Notifications.vue'),
  },
  {
    path: '/inquiry',
    component: () => import('@/layouts/inquiry/Inquiry.vue')
  },
  {
    path: '/user',
    component: () => import('@/layouts/user/User.vue'),
  },
  {
    path: '/settings',
    component: () => import('@/layouts/settings/Settings.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
