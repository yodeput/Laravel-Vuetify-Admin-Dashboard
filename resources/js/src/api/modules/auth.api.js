export default ({ request }) => ({
    MOCK_API() {
        return request({
            url: 'https://5e200e8ee31c6e0014c601bc.mockapi.io/api/v1/User',
            method: 'GET',
        })
    },

    LOGIN(data = {}) {
        return request({
            url: 'api/auth/login',
            method: 'POST',
            data,
        })
    },

    REGISTER(data = {}) {
        return request({
            url: 'api/auth/signup',
            method: 'POST',
            data,
        })
    },

    LOGOUT() {
        return request({
            url: 'api/auth/logout',
            method: 'POST',
        })
    },

    ME() {
        return request({
            url: 'api/auth/me',
            method: 'GET',
        })
    },

    FORGOT_PASSWORD(data = {}) {
        return request({
            url: 'api/auth/forgot-password',
            method: 'POST',
            data,
        })
    },

    RESET_PASSWORD(data = {}) {
        return request({
            url: 'api/auth/reset-password',
            method: 'POST',
            data,
        })
    },
    VERFIED_EMAIL(data = {}) {
        return request({
            url: 'api/auth/email/verify',
            method: 'POST',
            data,
        })
    },
})
