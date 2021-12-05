import { multiPart } from '@/api/service'

const apiURL = 'api/sys/users'

export default ({ request }) => ({
    GET_ALL_USER(data = {}) {
        return request({
            url: `${apiURL}/filter`,
            method: 'POST',
            data,
        })
    },

    CREATE_USER(data = {}) {
        return request({
            url: `${apiURL}/store`,
            method: 'POST',
            data,
        })
    },

    UPDATE_USER(data = {}) {
        return request({
            url: `${apiURL}/update/${data.id}`,
            method: 'PUT',
            data,
        })
    },

    GET_USER(id = {}) {
        return request({
            url: `${apiURL}/${id}`,
            method: 'GET',
        })
    },

    DELETE_USER(data = {}) {
        return request({
            url: `${apiURL}/${data.id}`,
            method: 'DELETE',
        })
    },

    RESTORE_USER(data = {}) {
        return request({
            url: `${apiURL}/restore/${data.id}`,
            method: 'PUT',
            data,
        })
    },

    DELETE_FORCE_USER(data = {}) {
        return request({
            url: `${apiURL}/forceDelete/${data.id}`,
            method: 'DELETE',
        })
    },

    EXPORT_PDF() {
        return request({
            url: `${apiURL}/exportPdf`,
            method: 'POST',
            responseType: 'blob',
        })
    },

    EXPORT_EXCEL() {
        return request({
            url: `${apiURL}/exportExcel`,
            method: 'POST',
            responseType: 'blob',
        })
    },

    IMPORT_DATA_USER(data) {
        return multiPart({
            url: `${apiURL}/import`,
            method: 'POST',
            data,
        })
    },

    GET_ME(data = {}) {
        return request({
            url: 'api/auth/me',
            method: 'GET',
        })
    },
    UPDATE_PROFILE(data = {}) {
        return request({
            url: 'api/auth/profile',
            method: 'POST',
            data,
        })
    },
    UPDATE_PASSWORD(data = {}) {
        return request({
            url: 'api/auth/password',
            method: 'POST',
            data,
        })
    },
    UPDATE_AVATAR(data = {}) {
        return request({
            url: 'api/auth/uploadPhoto',
            method: 'POST',
            data,
        })
    },
    RESET_AVATAR() {
        return request({
            url: 'api/auth/resetPhoto',
            method: 'POST',
        })
    },
})
