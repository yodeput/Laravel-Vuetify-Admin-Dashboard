export default [
    {
        path: '/master/office',
        name: 'master-office',
        component: () => import('@/views/dashboard/Dashboard.vue'),
        meta: {
            requiresAuth: true,
            pageTitle: 'Office',
        },
    },
]
