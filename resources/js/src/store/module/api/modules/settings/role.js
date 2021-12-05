import api from '@/api'
import i18n from '@/plugins/i18n'

function defaultForm() {
    return {
        name: '',
        display_name: '',
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
            total: 1,
            per_page: 20,
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
                office_id: '',
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
                office_id: '',
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
            if (state.filter.orderBy.column !== '') {
                commit('SET_BUSY', true)
                return new Promise((resolve, reject) => {
                    api.GET_ALL_ROLE(state.filter)
                        .then(response => {
                            state.result = response
                            commit('SET_BUSY', false)
                            resolve(response)
                        })
                        .catch(error => {
                            commit('SET_BUSY', false)
                            reject(error)
                        })
                })
            }
        },

        async GET_ALL_SELECTOR({ state, dispatch }) {
            if (state.filterSelector.orderBy.column !== '') {
                state.isBusy = true
                return new Promise((resolve, reject) => {
                    api.GET_ALL_ROLE(state.filterSelector)
                        .then(response => {
                            state.resultSelector = response
                            state.isBusy = false
                            resolve(response)
                        })
                        .catch(error => {
                            state.isBusy = false
                            reject(error)
                        })
                })
            }
        },

        async SHOW({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            return new Promise((resolve, reject) => {
                api
                    .GET_ROLE(payload)
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
            return new Promise((resolve, reject) => {
                api
                    .CREATE_ROLE(payload)
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
            return new Promise((resolve, reject) => {
                api
                    .UPDATE_ROLE(payload)
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

        async DELETE({ state, dispatch, commit }, payload = {}) {
            commit('SET_FORM_BUSY', true)
            return new Promise((resolve, reject) => {
                api
                    .DELETE_ROLE(payload)
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
    },
}
