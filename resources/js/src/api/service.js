import axios from 'axios'
import { get, isEmpty } from 'lodash'
import qs from 'qs'
import { createToastInterface } from 'vue-toastification'
import { utils } from '@/utils'
import { i18n } from '@/plugins/i18n'
import store from '@/store'

const showLoading = true
const toast = createToastInterface({
    hideProgressBar: false,
    timeout: false,
    position: 'top-right',
})

let toastId = null

function createService() {
    const service = axios.create()
    service.defaults.baseURL = '/'
    service.defaults.headers = {
        timeout: 5000,
    }

    service.interceptors.request.use(
        config => config,
        error => Promise.reject(error),
    )

    service.interceptors.response.use(
        response => {
            toast.dismiss('toastLoading')
            if (response.status === 200 || response.status === 201) {
                if (response.data.message) {
                    store.commit('SHOW_SUCCESS_NOTIF', {
                        show: true,
                        message: i18n.t(response.data.message),
                    })
                }
                return response
            }
            throw new Error(
                `${response.config.url}`,
            )
        },
        error => {
            toast.dismiss('toastLoading')
            const res = get(error, 'response')
            store.commit('SHOW_ERROR_NOTIF', {
                show: true,
                message: i18n.t(res.data.message),
            })
            if (res.data.message.includes('token')) {
                store.dispatch('api/auth/clearData')
            }
            throw res
        },
    )
    return service
}

function stringify(data) {
    return qs.stringify(data, {
        allowDots: true,
        encode: false,
    })
}

function createRequest(service) {
    // eslint-disable-next-line func-names
    return function (config) {
        const { loading } = store.state.notif
        const { token } = store.state.user
        let configDefault = {
            headers: {
                Accept: ' */* ,application/json, text/plain',
                'Content-Type': 'application/json;charset=UTF-8',
            },
        }
        if (token) {
            configDefault = {
                ...configDefault,
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        }

        const option = Object.assign(configDefault, config)

        if (!isEmpty(option.params)) {
            option.url = `${option.url}?${stringify(option.params)}`
            option.params = {}
        }
        if (loading) toast.warning(i18n.t('message.loading'), { id: 'toastLoading', timeout: false })

        return service(option)
    }
}

function createRequestMultipart(service) {
    // eslint-disable-next-line func-names
    return function (config) {
        const token = utils.cookies.get('token')
        const { loading } = store.state.notif
        let configDefault = {
            headers: {
                Accept: 'application/json, text/plain, */*',
                'Content-Type': 'multipart/form-data',
            },
        }
        if (token) {
            configDefault = {
                ...configDefault,
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        }

        const option = Object.assign(configDefault, config)

        if (!isEmpty(option.params)) {
            option.url = `${option.url}?${stringify(option.params)}`
            option.params = {}
        }
        toastId = loading ? toast.warning('Please wait...') : null
        console.log(toastId)
        return service(option)
    }
}

export const service = createService()
export const request = createRequest(service)
export const multiPart = createRequestMultipart(service)
