export function parse(jsonString = '{}', defaultValue = {}) {
    let result = defaultValue
    try {
        result = JSON.parse(jsonString)
    } catch (error) {
        console.log(error)
    }

    return result
}

export function response(data = {}, msg = '', code = 0) {
    return [200, {
        code,
        msg,
        data,
    }]
}

export function responseSuccess(data = {}, msg = '成功') {
    return response(data, msg)
}

export function responseError(data = {}, msg = '请求失败', code = 500) {
    return response(data, msg, code)
}
