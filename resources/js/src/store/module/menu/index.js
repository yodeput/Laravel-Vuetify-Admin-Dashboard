export default {
    namespaced: true,
    state: {
        menu: {},
        permissions: [],
    },
    actions: {
        async setMenu({ state, dispatch }, data) {
            state.menu = data
            await dispatch(
                'db/set',
                {
                    dbName: 'sys',
                    path: 'menu',
                    value: data,
                    user: false,
                },
                { root: true },
            )
        },

        async loadMenu({ state, dispatch }) {
            state.menu = await dispatch(
                'db/get',
                {
                    dbName: 'sys',
                    path: 'menu',
                    defaultValue: {},
                    user: false,
                },
                { root: true },
            )
        },
        async setPermissions({ state, dispatch }, data) {
            state.permissions = data
            await dispatch(
                'db/set',
                {
                    dbName: 'sys',
                    path: 'permissions',
                    value: data,
                    user: false,
                },
                { root: true },
            )
        },

        async loadPermissions({ state, dispatch }) {
            state.permissions = await dispatch(
                'db/get',
                {
                    dbName: 'sys',
                    path: 'permissions',
                    defaultValue: {},
                    user: false,
                },
                { root: true },
            )
        },

        async loadPermissions2({ state, dispatch }) {
            // eslint-disable-next-line no-async-promise-executor,no-unused-vars
            return new Promise(async (resolve, reject) => {
                state.permissions = await dispatch(
                    'db/get',
                    {
                        dbName: 'sys',
                        path: 'permissions',
                        defaultValue: {},
                        user: false,
                    },
                    { root: true },
                )
                resolve(state.permissions)
            })
        },

    },
}
