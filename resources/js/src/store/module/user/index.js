import api from '@/api'

const user = {
    namespaced: true,
    state: () => ({
        user: {},
    }),
    actions: {
        async setUser({ state }, data) {
            state.user = data
        },

        async loadUser({ state }) {
            const res = await api.ME()
            state.user = res.data
        },
    },
}

export default user
