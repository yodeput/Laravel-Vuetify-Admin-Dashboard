export default [
    {
        path: '/login',
        name: 'auth-login',
        component: () => import('@/views/authentication/Login.vue'),
        meta: {
            redirectIfLoggedIn: true,
            pageTitle: 'Login',
            layout: 'full',
        },
    },
    {
        path: '/register',
        name: 'auth-register',
        component: () => import('@/views/authentication/Register.vue'),
        meta: {
            redirectIfLoggedIn: true,
            pageTitle: 'Register',
            layout: 'full',
        },
    },
]
