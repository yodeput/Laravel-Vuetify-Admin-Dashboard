const apiURL = 'api/sys/roles'
export default ({ request }) => ({
    GET_ALL_ROLE(data = {}) {
        return request({
            url: `${apiURL}/filter`,
            method: 'POST',
            data,
        })
    },

    CREATE_ROLE(data = {}) {
        return request({
            url: `${apiURL}/store`,
            method: 'POST',
            data,
        })
    },

    UPDATE_ROLE(data = {}) {
        return request({
            url: `${apiURL}/update/${data.id}`,
            method: 'PUT',
            data,
        })
    },

    GET_ROLE(data = {}) {
        return request({
            url: `${apiURL}/${data.id}`,
            method: 'GET',
        })
    },

    GET_ROLE_MODULE(data = {}) {
        return request({
            url: `${apiURL}/getModule`,
            method: 'GET',
        })
    },

    DELETE_ROLE(data = {}) {
        return request({
            url: `${apiURL}/${data.id}`,
            method: 'DELETE',
        })
    },
})
