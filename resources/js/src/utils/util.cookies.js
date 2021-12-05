import Cookies from 'js-cookie'

const cookies = {}

cookies.set = function (name = 'default', value = '', cookieSetting = {}) {
    const currentCookieSetting = {
        expires: 1,
    }
    Object.assign(currentCookieSetting, cookieSetting)
    Cookies.set(
        name,
        value,
        currentCookieSetting,
    )
}

cookies.get = function (name = 'default') {
    return Cookies.get(name)
}

cookies.getAll = function () {
    return Cookies.get()
}

cookies.remove = function (name = 'default') {
    return Cookies.remove(name)
}

export default cookies
