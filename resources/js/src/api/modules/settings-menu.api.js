import { multiPart } from '@/api/service'

const apiURL = 'api/sys/modules'

export default ({ request }) => ({
    GET_ALL_MENU(data = {}) {
        return request({
            url: `${apiURL}/filter`,
            method: 'POST',
            data,
        })
    },

    CREATE_MENU(data = {}) {
        return request({
            url: `${apiURL}/store`,
            method: 'POST',
            data,
        })
    },

    UPDATE_MENU(data = {}) {
        return request({
            url: `${apiURL}/update/${data.id}`,
            method: 'PUT',
            data,
        })
    },

    GET_MENU(data = {}) {
        return request({
            url: `${apiURL}/${data.id}`,
            method: 'GET',
        })
    },

    DELETE_MENU(data = {}) {
        return request({
            url: `${apiURL}/${data.id}`,
            method: 'DELETE',
        })
    },

    RESTORE_MENU(data = {}) {
        return request({
            url: `${apiURL}/restore/${data.id}`,
            method: 'PUT',
            data,
        })
    },

    DELETE_FORCE_MENU(data = {}) {
        return request({
            url: `${apiURL}/forceDelete/${data.id}`,
            method: 'DELETE',
        })
    },

    COUNT_MENU(data = {}) {
        return request({
            url: `${apiURL}/count`,
            method: 'GET',
        })
    },
})
