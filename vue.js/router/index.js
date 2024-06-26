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
    children: [
      {
        path: 'notice_setting',
        component: () => import('@/components/NoticeSetting.vue'),
      },
      {
        path: 'reset_password',
        component: () => import('@/components/ResetPassword.vue'),
      }
    ]
  },
  {
    path: '/post',
    name: 'post',
    component: () => import('@/layouts/postDetail/PostDetail.vue'),
  },
  {
    path: '/detail',
    name: 'detail',
    component: () => import('@/layouts/ProductDetail/ProductDetail.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  /**
   * laravel置き換え用:
   * history: createWebHistory(import.meta.env.BASE_URL),
   */
  routes,
})

export default router
