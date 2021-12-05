import api from '@/api'

function defaultForm() {
    return {
        nip: '',
        name: '',
        password: '',
        phone: '',
        address: '',
        roles: [{
            id: '',
            display_name: '',
            name: '',
        }],
        image: '/assets/images/avatars/avatar.png',
    }
}

export default {
    namespaced: true,
    state: {
        error: {},
        result: {
            current_page: 1,
            from: 1,
            to: 1,
            per_page: 20,
            total: 1,
            data: [],
        },
        resultSelector: {
            current_page: 1,
            from: 1,
            to: 1,
            total: 1,
            per_page: 20,
            data: [],
        },
        form: defaultForm(),
        statusArray: [
            {
                value: 1,
                label: 'field.active',
            },
            {
                value: 0,
                label: 'field.disable',
            },
        ],
        filter: {
            page: 1,
            per_page: 20,
            advance: {
                mstrffc_id: '',
            },
            orderBy: {
                column: 'updated_at',
                desc: true,
            },
            search: '',
        },
        filterSelector: {
            page: 1,
            per_page: 20,
            advance: {
                mstrffc_id: '',
            },
            orderBy: {
                column: 'name',
                desc: false,
            },
            search: '',
        },
        isBusy: false,
        isFormBusy: false,
        formDialogState: false,
        dialogImportState: false,
        dataCount: {},
    },
    mutations: {
        CLEAR_ERROR(state) {
            state.error = {}
        },
        SET_RESULT(state, payload) {
            state.result = payload
        },
        SET_FORM(state, payload) {
            state.form = payload
        },
        SET_FILTER(state, payload) {
            state.filter = payload
        },
        SET_FILTER_SELECTOR(state, payload) {
            state.filterSelector = payload
        },
        SET_BUSY(state, payload) {
            state.isBusy = payload
        },
        SET_FORM_BUSY(state, payload) {
            state.isFormBusy = payload
        },
        RESET_FORM(state) {
            state.form = defaultForm()
            state.error = {}
        },
        FORM_DIALOG_STATE(state, payload) {
            state.formDialogState = payload
        },
        DIALOG_IMPORT_STATE(state, payload) {
            state.dialogImportState = payload
        },
        SET_DATA_COUNT(state, payload) {
            state.dataCount = payload
        },
    },
    actions: {
        async GET_ALL({ state, commit, dispatch }) {
            commit('SHOW_LOADING', false, { root: true })
            commit('SET_BUSY', true)
            return new Promise((resolve, reject) => {
                api.GET_ALL_USER(state.filter)
                    .then(response => {
                        const { data, headers } = response
                        state.result = data
                        state.dataCount = headers
                        commit('SET_BUSY', false)
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_BUSY', false)
                        reject(error)
                    })
            })
        },

        async GET_ALL_SELECTOR({ state, commit }) {
            commit('SHOW_LOADING', false, { root: true })
            commit('SET_BUSY', true)
            return new Promise((resolve, reject) => {
                api.GET_ALL_USER(state.filterSelector)
                    .then(response => {
                        state.resultSelector = response
                        commit('SET_BUSY', true)
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_BUSY', true)
                        reject(error)
                    })
            })
        },

        async SHOW({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', false, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .GET_USER(payload)
                    .then(response => {
                        commit('SET_FORM_BUSY', false)
                        commit('SET_FORM', response.data)
                        commit('FORM_DIALOG_STATE', true)
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_FORM_BUSY', false)
                        reject(error)
                    })
            })
        },

        async CREATE({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .CREATE_USER(payload)
                    .then(response => {
                        commit('SET_FORM_BUSY', false)
                        dispatch('GET_ALL')
                        commit('FORM_DIALOG_STATE', false)
                        commit('RESET_FORM')
                        resolve(response)
                    })
                    .catch(error => {
                        if (error.status === 422) {
                            state.error = error.data.message
                        }
                        state.isFormBusy = false
                        reject(error)
                    })
            })
        },

        async EDIT({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .UPDATE_USER(payload)
                    .then(response => {
                        commit('SET_FORM_BUSY', false)
                        dispatch('GET_ALL')
                        commit('FORM_DIALOG_STATE', false)
                        commit('RESET_FORM')
                        resolve(response)
                    })
                    .catch(error => {
                        if (error.status === 422) {
                            state.error = error.data.message
                        }
                        state.isFormBusy = false
                        reject(error)
                    })
            })
        },

        async RESTORE({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .RESTORE_USER(payload)
                    .then(response => {
                        commit('SET_FORM_BUSY', false)
                        dispatch('GET_ALL')
                        commit('FORM_DIALOG_STATE', false)
                        commit('RESET_FORM')
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_FORM_BUSY', false)
                        reject(error)
                    })
            })
        },

        async DELETE({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .DELETE_USER(payload)
                    .then(response => {
                        commit('SET_FORM_BUSY', false)
                        dispatch('GET_ALL')
                        commit('FORM_DIALOG_STATE', false)
                        commit('RESET_FORM')
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_FORM_BUSY', false)
                        reject(error)
                    })
            })
        },

        async FORCE_DELETE({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .DELETE_FORCE_USER(payload)
                    .then(response => {
                        dispatch('GET_ALL')
                        commit('RESET_FORM')
                        commit('FORM_DIALOG_STATE', false)
                        commit('SET_FORM_BUSY', false)
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_FORM_BUSY', false)
                        reject(error)
                    })
            })
        },

        async EXPORT_DATA({ state, dispatch, commit }, payload = {}) {
            return new Promise((resolve, reject) => {
                state.isBusy = true
                if (payload === 'pdf') {
                    api
                        .EXPORT_PDF(payload)
                        .then(response => {
                            state.isBusy = false
                            const url = window.URL.createObjectURL(new Blob([response]))
                            const link = document.createElement('a')
                            link.href = url
                            const todayDate = new Date().toISOString().slice(0, 10)
                            link.setAttribute('download', `idface_data-pengguna-${todayDate}.pdf`)
                            document.body.appendChild(link)
                            link.click()
                            resolve(response)
                        })
                        .catch(error => {
                            state.isBusy = false
                            reject(error)
                        })
                } else {
                    api
                        .EXPORT_EXCEL(payload)
                        .then(response => {
                            state.isBusy = false
                            const url = window.URL.createObjectURL(new Blob([response]))
                            const link = document.createElement('a')
                            link.href = url
                            const todayDate = new Date().toISOString().slice(0, 10)
                            link.setAttribute('download', `idface_data-pengguna-${todayDate}.xlsx`)
                            document.body.appendChild(link)
                            link.click()
                            resolve(response)
                            resolve(response)
                        })
                        .catch(error => {
                            state.isBusy = false
                            reject(error)
                        })
                }
            })
        },

        async IMPORT_DATA({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .IMPORT_DATA_USER(payload)
                    .then(response => {
                        dispatch('GET_ALL')
                        commit('DIALOG_IMPORT_STATE', false)
                        commit('SET_FORM_BUSY', false)
                        resolve(response)
                    })
                    .catch(error => {
                        commit('SET_FORM_BUSY', false)
                        reject(error)
                    })
            })
        },

        async UPDATE_PROFILE({ dispatch, commit }, payload = {}) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .UPDATE_PROFILE(payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        async UPDATE_PASSWORD({ dispatch, commit }, payload = {}) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .UPDATE_PASSWORD(payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        async UPDATE_AVATAR({ dispatch, commit }, payload = {}) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .UPDATE_AVATAR(payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        async RESET_AVATAR({ dispatch, commit }, payload = {}) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api
                    .RESET_AVATAR(payload)
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
    },
}
