// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
{
    path: '/',
    redirect: '/home',
},
{
    path: '/home',
    component: () => import('@/Layouts/home/Home.vue'),
},
{
    path: '/search',
    component: () => import('@/Layouts/search/Search.vue'),
},
{
    path: '/inquiry',
    component: () => import('@/Layouts/inquiry/Inquiry.vue')
},
{
    // path: '/user',
    path: '/user/:userId',
    name: 'user',
    component: () => import('@/Layouts/user/User.vue'),
    props: true,
},
{
    path: '/settings',
    component: () => import('@/Layouts/settings/Settings.vue'),
    children: [
    {
        path: 'reset_password',
        component: () => import('@/Components/ResetPassword.vue'),
    }
    ]
},
{
    path: '/post/:postId/',
    name: 'post',
    component: () => import('@/Layouts/postDetail/PostDetail.vue'),
    props: true,
},
]

const router = createRouter({
history: createWebHistory(import.meta.env.BASE_URL),
routes,
})

export default router
