import api from '@/api'

function defaultForm() {
  return {
    name: '',
    label: '',
    route: '',
    order: '',
    icon: '',
    is_header: false,
    is_group: false,
    parent_id: null,
    parent: {},
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
        office_id: '',
      },
      orderBy: {
        column: 'order',
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
        column: 'order',
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
    async ADDCHILD({ state, dispatch, commit }, payload = {}) {
      commit('SET_FORM', {
        ...defaultForm(),
        parent_id: payload.id,
        parent: payload,
        name: `${payload.name}-`,
        route: `${payload.name}-`,
      })
      commit('FORM_DIALOG_STATE', true)
    },

    async GET_DATA_COUNT({ state, dispatch }) {
      return new Promise((resolve, reject) => {
        api.COUNT_MENU()
          .then(response => {
            state.dataCount = response
            resolve(response)
          })
          .catch(error => {
            reject(error)
          })
      })
    },

    async GET_ALL({ state, commit, dispatch }) {
      if (state.filter.orderBy.column !== '') {
        commit('SET_BUSY', true)
        dispatch('GET_DATA_COUNT')
        return new Promise((resolve, reject) => {
          api.GET_ALL_MENU(state.filter)
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
          api.GET_ALL_MENU(state.filterSelector)
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
          .GET_MENU(payload)
          .then(response => {
            commit('SET_FORM_BUSY', false)
            commit('SET_FORM', response.data)
            commit('FORM_DIALOG_STATE', true)
            resolve(response)
          })
          .catch(error => {
            commit('SET_FORM_BUSY', false)
            console.log(error)
            reject(error)
          })
      })
    },

    async CREATE({ state, dispatch, commit }, payload = {}) {
      commit('SET_FORM_BUSY', true)
      return new Promise((resolve, reject) => {
        api
          .CREATE_MENU(payload)
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
          .UPDATE_MENU(payload)
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
      return new Promise((resolve, reject) => {
        api
          .RESTORE_MENU(payload)
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
      return new Promise((resolve, reject) => {
        api
          .DELETE_MENU(payload)
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
      return new Promise((resolve, reject) => {
        api
          .DELETE_FORCE_MENU(payload)
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

    async IMPORT_DATA({ state, dispatch, commit }, payload = {}) {
      commit('SET_FORM_BUSY', true)
      return new Promise((resolve, reject) => {
        api
          .IMPORT_DATA_MENU(payload)
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
  },
}
