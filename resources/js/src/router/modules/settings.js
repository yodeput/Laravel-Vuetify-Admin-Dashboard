export default [
    {
        path: '/settings/users',
        name: 'settings-users',
        component: () => import('@/views/settings/user/index.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Users',
            breadcrumb: [
                {
                    label: 'Settings',
                },
                {
                    label: 'Users',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/settings/roles',
        name: 'settings-roles',
        component: () => import('@/views/Error.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Roles',
            breadcrumb: [
                {
                    label: 'Settings',
                },
                {
                    label: 'Roles',
                    active: true,
                },
            ],
        },
    },
    {
        path: '/settings/menu',
        name: 'settings-menu',
        component: () => import('@/views/Error.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Menus',
            breadcrumb: [
                {
                    label: 'Settings',
                },
                {
                    label: 'Menus',
                    active: true,
                },
            ],
        },
    },
]
