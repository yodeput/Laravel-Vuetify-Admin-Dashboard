export default [
    {
        path: '/typography',
        name: 'typography',
        component: () => import('@/views/typography/Typography.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Typography',
        },
    },
    {
        path: '/icons',
        name: 'icons',
        component: () => import('@/views/icons/Icons.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Icons',
        },
    },
    {
        path: '/cards',
        name: 'cards',
        component: () => import('@/views/cards/Card.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'cards',
        },
    },
    {
        path: '/simple-table',
        name: 'simple-table',
        component: () => import('@/views/simple-table/SimpleTable.vue'),
    },
    {
        path: '/form-layouts',
        name: 'form-layouts',
        component: () => import('@/views/form-layouts/FormLayouts.vue'),
    },
    {
        path: '/pages/account-settings',
        name: 'pages-account-settings',
        component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
    },
]
