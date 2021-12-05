import Vue from 'vue'
import VueRouter from 'vue-router'
import auth from '@/router/modules/auth'
import settings from '@/router/modules/settings'
// eslint-disable-next-line import/named,import/no-cycle
import { isUserLoggedIn } from '@/utils'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        redirect: 'dashboard',
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: () => import('@/views/dashboard/Dashboard.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Dashboard',
        },
    },
    ...auth,
    ...settings,
    {
        path: '/error-404',
        name: 'error-404',
        component: () => import('@/views/Error.vue'),
        meta: {
            pageTitle: 'Page Not Found',
            layout: 'full',
        },
    },
    {
        path: '*',
        redirect: 'error-404',
    },
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes,
})
const findPermission = (arr, perm) => {
    if (arr && arr.find(e => e === perm.toString())) {
        return 0
    }
    return -1
}

router.beforeEach((to, from, next) => {
    const isLoggedIn = isUserLoggedIn()
    store.dispatch('menu/loadPermissions2').then(arr => {
        if (arr && Array.isArray(arr)) {
            if (to.meta.permission && to.meta.permission !== 'undefined') {
                if (findPermission(arr, to.meta.permission) > -1 || to.meta.permission === 'general') {
                    if (!isLoggedIn && to.meta.requiresAuth) {
                        next({
                            name: 'auth-login',
                            query: { to: to.path },
                        })
                    }
                    next()
                }
                next({ name: 'not-authorized' })
            }
        }

        if (!isLoggedIn && to.meta.requiresAuth) {
            next({
                name: 'auth-login',
                query: { to: to.path },
            })
        }

        if (to.meta.redirectIfLoggedIn && isLoggedIn) {
            next({ name: 'dashboard' })
        }

        return next()
    })
})

export default router
