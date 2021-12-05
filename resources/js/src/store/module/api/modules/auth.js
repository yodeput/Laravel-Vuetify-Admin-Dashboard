import { commit } from 'lodash/seq'
import { utils } from '@/utils'
import router from '@/router'
import api from '@/api'

export default {
    namespaced: true,
    actions: {
        async login({ dispatch, state, commit }, payload) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api.LOGIN(payload)
                    .then(response => {
                        const { data } = response.data
                        utils.cookies.set('token', data.token)
                        dispatch('me')
                        dispatch('menu/setMenu', data.menu, { root: true })
                        dispatch('menu/setPermissions', data.permissions, { root: true })
                        router.push({ name: 'dashboard' }).catch(e => {})
                        resolve(response.data)
                    }).catch(error => {
                        reject(error)
                    })
            })
        },
        async forgotPassword({ dispatch, state }, data) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api.FORGOT_PASSWORD(data)
                    .then(response => {
                        resolve(response.data)
                    }).catch(error => {
                        reject(error)
                    })
            })
        },
        async resetPassword({ dispatch, state }, data) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api.RESET_PASSWORD(data)
                    .then(response => {
                        resolve(response.data)
                    }).catch(error => {
                        reject(error)
                    })
            })
        },
        async verifyEmail({ dispatch, state }, data) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api.VERFIED_EMAIL(data)
                    .then(response => {
                        resolve(response.data)
                    }).catch(error => {
                        reject(error)
                    })
            })
        },
        async me({ dispatch, commit }) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise((resolve, reject) => {
                api.ME()
                    .then(response => {
                        const { data } = response.data
                        dispatch('user/setUser', data.user, { root: true })
                        dispatch('menu/setMenu', data.menu, { root: true })
                        dispatch('menu/setPermissions', data.permissions, { root: true })
                        resolve(response)
                    }).catch(error => {
                        reject(error)
                    })
            })
        },
        async register(
            { dispatch },
            {
                name = '',
                email = '',
                username = '',
                password = '',
                passwordConfirm = '',
            } = {},
        ) {
            await api.REGISTER({
                name, email, username, password, passwordConfirm,
            })
        },

        async logout({ commit, dispatch }) {
            commit('SHOW_LOADING', true, { root: true })
            return new Promise(async (resolve, reject) => {
                await api.LOGOUT()
                dispatch('clearData')
            })
        },
        async clearData({ commit, dispatch }) {
            utils.cookies.remove('token')
            dispatch('menu/setMenu', null, { root: true })
            dispatch('menu/setPermissions', null, { root: true })
            router.push({ name: 'auth-login' }).catch(e => {})
        },
    },
}
