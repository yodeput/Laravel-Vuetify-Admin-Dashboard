export default {
    state: {
        loading: true,
        success: {
            show: false,
            title: '',
            message: '',
        },
        error: {
            show: false,
            title: '',
            message: '',
        },
    },
    getters: {},
    mutations: {
        SHOW_LOADING(state, val) {
            state.loading = val
        },
        SHOW_SUCCESS_NOTIF(state, val) {
            state.success = val
        },
        SHOW_ERROR_NOTIF(state, val) {
            state.error = val
        },
    },
    actions: {},
}
